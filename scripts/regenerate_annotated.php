<?php
// scripts/regenerate_annotated.php
// Usage: php scripts/regenerate_annotated.php
// This will read DroneDetection records with predictions and draw boxes using GD.

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArgvInput,
    new Symfony\Component\Console\Output\ConsoleOutput
);

use App\Models\DroneDetection;
use Illuminate\Support\Facades\Storage;

echo "Starting regenerate annotated images (GD fallback)...\n";

$rows = DroneDetection::orderBy('id')->get();

if (!$rows->count()) {
    echo "No detections found.\n";
    exit(0);
}

foreach ($rows as $d) {
    echo "Processing ID {$d->id} ...\n";
    $preds = json_decode($d->predictions ?? '[]', true);
    $imagePath = storage_path('app/public/' . ($d->image_path ?? ''));
    if (!file_exists($imagePath)) {
        echo "  No original image file found ({$imagePath}), skipping draw for ID {$d->id}\n";
        // still save counts (0) in DB if desired
        $d->total_detected = is_array($preds) ? count($preds) : 0;
        $d->infected_count = null;
        $d->healthy_count = null;
        $d->save();
        continue;
    }

    $im = @imagecreatefromstring(file_get_contents($imagePath));
    if (!$im) {
        echo "  Failed to create image resource for ID {$d->id}\n";
        continue;
    }

    $w = imagesx($im);
    $h = imagesy($im);

    // Colors
    $col_red = imagecolorallocate($im, 255, 50, 50);
    $col_green = imagecolorallocate($im, 50, 200, 80);
    $col_blue = imagecolorallocate($im, 60, 130, 255);
    $col_white = imagecolorallocate($im, 255,255,255);

    $total = 0;
    $infected = 0;

    foreach ($preds as $p) {
        $total++;
        $label = strtolower($p['label'] ?? '');
        $conf = floatval($p['confidence'] ?? 0);
        $bbox = $p['bbox'] ?? null;

        // decide infected: if label contains 'ganoderma' OR confidence high
        $isInfected = false;
        if (strpos($label, 'ganoderma') !== false) $isInfected = true;
        if ($conf >= 0.8) $isInfected = true;

        if ($isInfected) $infected++;

        // bbox handling: handle either [x,y,w,h] or [x1,y1,x2,y2] or normalized (0..1)
        if (is_array($bbox) && count($bbox) >= 4) {
            // detect if values <= 1 (normalized)
            $norm = max($bbox) <= 1.0;
            if ($norm) {
                // assume [x,y,w,h] normalized
                $x = intval($bbox[0] * $w);
                $y = intval($bbox[1] * $h);
                $bw = intval($bbox[2] * $w);
                $bh = intval($bbox[3] * $h);
                $x2 = $x + $bw;
                $y2 = $y + $bh;
            } else {
                // if values look like [x1,y1,x2,y2] (two corners) or [x,y,w,h]
                // heuristic: if bbox[2] > bbox[0] and bbox[3] > bbox[1] and difference small => assume x2,y2
                if ($bbox[2] > $bbox[0] && $bbox[3] > $bbox[1] && ($bbox[2]-$bbox[0] > 5) && ($bbox[3]-$bbox[1] > 5)) {
                    // treat as x1,y1,x2,y2
                    $x = intval($bbox[0]);
                    $y = intval($bbox[1]);
                    $x2 = intval($bbox[2]);
                    $y2 = intval($bbox[3]);
                } else {
                    // treat as x,y,w,h in pixels
                    $x = intval($bbox[0]);
                    $y = intval($bbox[1]);
                    $x2 = $x + intval($bbox[2]);
                    $y2 = $y + intval($bbox[3]);
                }
            }

            // draw rectangle thicker by drawing several rectangles
            $color = $isInfected ? $col_red : $col_green;
            for ($i=0;$i<3;$i++){
                imagerectangle($im, $x-$i, $y-$i, $x2+$i, $y2+$i, $color);
            }

            // label + confidence
            $txt = ($p['label'] ?? 'obj') . ' ' . round($conf*100,1) . '%';
            imagestring($im, 3, max(2,$x), max(2,$y-14), $txt, $col_white);
        }
    } // foreach preds

    $healthy = max(0, $total - $infected);

    // compose annotated filename and save
    $annotName = 'annotated_' . uniqid() . '.jpg';
    $annotRel = 'annotated/' . $annotName;
    $savePath = storage_path('app/public/' . $annotRel);
    imagejpeg($im, $savePath, 90);
    imagedestroy($im);

    // update record
    $d->annotated_path = $annotRel;
    $d->total_detected = $total;
    $d->infected_count = $infected;
    $d->healthy_count = $healthy;
    $d->save();

    echo "  Saved ID {$d->id} (total={$total}, infected={$infected}, healthy={$healthy})\n";
}

echo "Done regenerating annotated images.\n";
$kernel->terminate($input, 0);
