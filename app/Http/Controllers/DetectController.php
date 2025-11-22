<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DroneDetection;
use App\Jobs\ProcessDroneImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DetectController extends Controller
{
    public function detect(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240' // max 10MB
        ]);

        // simpan file ke storage/app/public/drone_images
        $file = $request->file('image');
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/drone_images', $filename); // simpan di storage/app/public/drone_images
        $publicPath = Storage::url('drone_images/' . $filename); // /storage/drone_images/xxx.jpg

        // buat record detection (predictions null awalnya)
        $d = DroneDetection::create([
            'user_id' => $request->user()?->id ?? null,
            'image_path' => 'drone_images/' . $filename,
            'predictions' => null,
            'infected' => 0,
        ]);

        // dispatch background job (gunakan id detection agar job bisa update record)
        ProcessDroneImage::dispatch($d->id, $request->user()?->id ?? null);

        return response()->json([
            'ok' => true,
            'detection_id' => $d->id,
            'image_url' => $publicPath
        ]);
    }

    public function status($id)
    {
        $d = \App\Models\DroneDetection::find($id);

        if (!$d) {
            return response()->json(['error' => 'not_found'], 404);
        }

        return response()->json([
            "id" => $d->id,
            "predictions" => $d->predictions ? json_decode($d->predictions, true) : [],
            "infected" => $d->infected,
            "annotated_url" => $d->annotated_path 
                ? asset("storage/" . $d->annotated_path)
                : null,
            "done" => $d->predictions !== null
        ]);
    }

}
