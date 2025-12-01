<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\DroneDetection;

class RegenerateAnnotated extends Command
{
    protected $signature = 'regenerate:annotated {--threshold-gano=0.3 : Confidence threshold to mark Ganoderma as infected} {--threshold-global=0.8 : Global confidence threshold}';
    protected $description = 'Regenerate annotated images (draw bounding boxes) and recompute infected/healthy counts from predictions using GD';

    public function handle()
    {
        $this->info('Starting regenerate annotated images...');

        $thresholdGano = (float) $this->option('threshold-gano');
        $thresholdGlobal = (float) $this->option('threshold-global');

        // Make sure public disk exists
        $disk = Storage::disk('public');

        $detections = DroneDetection::orderBy('id', 'asc')->get();
        $this->info('Found ' . $detections->count() . ' detection(s)');

        foreach ($detections as $d) {
            $this->line("Processing ID {$d->id} ...");

            // get original image path
            $imageUrl = $d->image_url ?? null;
            $imagePath = null;

            if ($imageUrl) {
                // If stored as full url (http://localhost:8000/storage/...), try to resolve to storage path
                $basename = basename(parse_url($imageUrl, PHP_URL_PATH));
                $possible = "drone_images/{$basename}";
                if ($disk->exists($possible)) {
                    $imagePath = $disk->path($possible);
                } else {
                    // fallback: if annotated_path previously existed, skip
                    $this->warn("  Original image not found in storage/public/drone_images: {$possible}");
                }
            }

            // If no image found, skip drawing but still compute counts if predictions exist
            $predictions = $d->predictions;
            if (is_string($predictions) && $predictions !== '') {
                // stored as JSON string in DB
                $predictions = json_decode($predictions, true);
            }
            if (!is_array($predictions)) {
                $predictions = [];
            }

            // compute infected counts
            $infected = 0;
            foreach ($predictions as $p) {
                $label = isset($p['label']) ? strtolower((string)$p['label']) : '';
                $conf = isset($p['confidence']) ? (float)$p['confidence'] : 0.0;

                if (strpos($label, 'ganoderma') !== false) {
                    if ($conf >= $thresholdGano) {
                        $infected++;
                        continue;
                    }
                }

                if ($conf >= $thresholdGlobal) {
                    $infected++;
                    continue;
                }

                // else not infected
            }

            $total = count($predictions);
            $healthy = max(0, $total - $infected);

            // update DB fields safely
            $d->total_detected = $total;
            $d->infected_count = $infected;
            $d->healthy_count = $healthy;

            // Build annotated file (if original image exists)
            if ($imagePath && file_exists($imagePath)) {
                // load image via GD
                $img = @imagecreatefromstring(file_get_contents($imagePath));
                if ($img === false) {
                    $this->warn("  Could not open image for ID {$d->id}");
                } else {
                    $w = imagesx($img);
                    $h = imagesy($img);

                    // colors
                    $colorInfected = imagecolorallocate($img, 239, 68, 68); // red
                    $colorHealthy = imagecolorallocate($img, 16, 185, 129); // green
                    $colorText = imagecolorallocate($img, 255, 255, 255); // white
                    $bgText = imagecolorallocatealpha($img, 0, 0, 0, 60); // translucent bg for text

                    imagesetthickness($img, 3);

                    // draw bboxes
                    foreach ($predictions as $idx => $p) {
                        if (!isset($p['bbox']) || !is_array($p['bbox'])) continue;
                        // expecting [x1,y1,x2,y2] or [x,y,w,h] — detect format
                        $bbox = $p['bbox'];
                        if (count($bbox) === 4) {
                            $x1 = (int)$bbox[0];
                            $y1 = (int)$bbox[1];
                            $x2 = (int)$bbox[2];
                            $y2 = (int)$bbox[3];

                            // if coords look like x,y,width,height (small width) we try to detect: if x2 <= 1 or y2 <= 1 treat as width/height? 
                            // We'll try: if x2 < x1 or y2 < y1 treat as w,h
                            if ($x2 < $x1 || $y2 < $y1) {
                                // interpret as x,y,w,h
                                $wbox = $x2;
                                $hbox = $y2;
                                $x2 = $x1 + $wbox;
                                $y2 = $y1 + $hbox;
                            }
                        } else {
                            continue;
                        }

                        $label = isset($p['label']) ? (string)$p['label'] : 'object';
                        $conf = isset($p['confidence']) ? (float)$p['confidence'] : 0.0;

                        // decide color: infected if ganoderma or high confidence
                        $isInfected = false;
                        if (stripos($label, 'ganoderma') !== false && $conf >= $thresholdGano) $isInfected = true;
                        if ($conf >= $thresholdGlobal) $isInfected = true;

                        $col = $isInfected ? $colorInfected : $colorHealthy;
                        imagerectangle($img, $x1, $y1, $x2, $y2, $col);

                        // draw label background
                        $txt = strtoupper($label) . ' ' . round($conf * 100, 1) . '%';
                        $font = 5; // built-in font
                        $txt_w = imagefontwidth($font) * strlen($txt);
                        $txt_h = imagefontheight($font);

                        // background rectangle top-left of bbox
                        $rx1 = max(0, $x1);
                        $ry1 = max(0, $y1 - $txt_h - 6);
                        $rx2 = min($w - 1, $rx1 + $txt_w + 8);
                        $ry2 = min($h - 1, $ry1 + $txt_h + 6);

                        // semi-opaque box
                        imagefilledrectangle($img, $rx1, $ry1, $rx2, $ry2, $bgText);
                        // text
                        imagestring($img, $font, $rx1 + 4, $ry1 + 2, $txt, $colorText);
                    }

                    // prepare annotated filename
                    $annotName = "annotated_{$d->id}.jpg";
                    $annotPath = 'annotated/' . $annotName;
                    $fullPath = $disk->path($annotPath);

                    // ensure dir exists - Storage handles that
                    $dir = dirname($fullPath);
                    if (!is_dir($dir)) mkdir($dir, 0755, true);

                    // save image
                    imagejpeg($img, $fullPath, 85);
                    imagedestroy($img);

                    // update DB annotated path/url fields if exist
                    // If your model has annotated_path and annotated_url columns: update both
                    if (property_exists($d, 'annotated_path')) {
                        $d->annotated_path = $annotPath;
                    }
                    // annotated_url expected to be accessible via storage symlink (storage/annotated/...)
                    $d->annotated_url = url('/storage/' . $annotPath);
                } // end if loaded image
            } else {
                $this->warn("  No original image file found, skipping draw for ID {$d->id}");
            }

            $d->save();
            $this->info("  Saved ID {$d->id} (total={$total}, infected={$infected}, healthy={$healthy})");
        }

        $this->info('Done regenerating annotated images.');
        return 0;
    }
}
