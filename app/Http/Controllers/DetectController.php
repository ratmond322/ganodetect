<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DroneDetection;
use App\Jobs\ProcessDroneImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DetectController extends Controller
{
    public function detect(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240'
        ]);

        $file = $request->file('image');

        // preserve original name for block parsing
        $origName = $file->getClientOriginalName();

        // store with randomized name but keep original ext
        $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/drone_images', $filename);
        $publicPath = Storage::url('drone_images/' . $filename);

        // try extract block from original filename (robust heuristics)
        $block = $this->extractBlockFromFilename($origName);

        $d = DroneDetection::create([
            'user_id' => $request->user()?->id ?? null,
            'image_path' => 'drone_images/' . $filename,
            'predictions' => null,
            'infected_count' => null,
            'total_detected' => null,
            'healthy_count' => null,
            'block' => $block,
            'status' => 'queued',
        ]);

        ProcessDroneImage::dispatch($d->id);

        return response()->json([
            'ok' => true,
            'detection_id' => $d->id,
            'image_url' => $publicPath
        ]);
    }

    /**
     * Try to infer block name from uploaded filename.
     * Returns null if not found.
     */
    protected function extractBlockFromFilename(?string $name): ?string
    {
        if (empty($name)) return null;
        $s = strtolower($name);

        // common patterns used in your dataset: contains 'blok' or 'blok_' or 'BLOK_'
        // Normalize separators
        $s = str_replace(['-', ' '], '_', $s);

        // 1) look for "blok_" followed by token(s)
        if (preg_match('/blok_([a-z0-9_]+)/i', $s, $m)) {
            // take only the block token part until a file-ext-like or rf token
            $token = $m[1];
            // drop tailing tokens like "png", "rf..." or long hex: stop at next "."
            $token = preg_replace('/(\.jpg|\.jpeg|\.png|\.rf.*|_png.*$)/i', '', $token);
            // further trim at very long hex if present
            $token = preg_replace('/_[0-9a-f]{8,}$/i', '', $token);
            return trim($token, '_');
        }

        // 2) if 'blok' word standalone
        if (preg_match('/\bblok\b[_\-]?([a-z0-9_]+)/i', $s, $m2)) {
            $token = $m2[1];
            $token = preg_replace('/(\.jpg|\.jpeg|\.png|\.rf.*)/i', '', $token);
            return trim($token, '_');
        }

        // 3) As fallback: try capture something like GUB_AFD_IV_BLOK_06F_08 -> take the blob after 'blok_'
        if (preg_match('/([A-Z0-9_]+_blok_[A-Z0-9_]+)/i', $name, $m3)) {
            $raw = $m3[1];
            if (preg_match('/blok[_\-]?([A-Za-z0-9_]+)/i', $raw, $m4)) {
                return trim(strtolower($m4[1]), '_');
            }
        }

        return null;
    }


    public function status($id)
    {
        $d = \App\Models\DroneDetection::find($id);

        if (!$d) {
            return response()->json(['error' => 'not_found'], 404);
        }

        $preds = json_decode($d->predictions ?? '[]', true) ?: [];

        $total = $d->total_detected ?? count($preds);
        $infected = $d->infected_count ?? null;
        if ($infected === null) {
            $infected = 0;
            foreach ($preds as $p) {
                $label = strtolower($p['label'] ?? '');
                $conf = (float)($p['confidence'] ?? 0);
                if (str_contains($label, 'ganoderma') || $conf >= 0.5) $infected++;
            }
        }
        $healthy = $d->healthy_count ?? max(0, $total - $infected);

        return response()->json([
            "id" => $d->id,
            "predictions" => $preds,
            "infected_count" => $infected,
            "healthy_count" => $healthy,
            "total_detected" => $total,
            "annotated_url" => $d->annotated_path ? asset("storage/" . $d->annotated_path) : null,
            "image_url" => $d->image_path ? asset("storage/" . $d->image_path) : null,
            "lat" => $d->lat,
            "lng" => $d->lng,
            "block" => $d->block,
            "done" => $d->predictions !== null
        ]);
    }

}
