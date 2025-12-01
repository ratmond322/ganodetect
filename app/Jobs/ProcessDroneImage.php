<?php

namespace App\Jobs;

use App\Models\DroneDetection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class ProcessDroneImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $detectionId;
    public int $tries = 3;

    public function __construct(int $detectionId)
    {
        $this->detectionId = $detectionId;
    }

    public function handle(): void
    {
        $detection = DroneDetection::find($this->detectionId);
        if (!$detection) {
            Log::warning("ProcessDroneImage: detection {$this->detectionId} not found.");
            return;
        }

        $imagePath = $detection->image_path ?? null;
        if (!$imagePath) {
            Log::error("ProcessDroneImage: detection {$detection->id} has no image_path.");
            return;
        }

        if (!Storage::disk('public')->exists($imagePath)) {
            Log::error("ProcessDroneImage: image missing storage/app/public/{$imagePath}");
            return;
        }

        $fullImagePath = Storage::disk('public')->path($imagePath);

        // prepare output folders & paths
        $predsDir = storage_path('app/public/preds');
        $annotatedDir = storage_path('app/public/annotated');
        if (!file_exists($predsDir)) mkdir($predsDir, 0755, true);
        if (!file_exists($annotatedDir)) mkdir($annotatedDir, 0755, true);

        $outJson = $predsDir . DIRECTORY_SEPARATOR . 'detection_' . $detection->id . '.json';
        $outAnnotated = $annotatedDir . DIRECTORY_SEPARATOR . 'annotated_' . $detection->id . '.jpg';

        // python binary and script
        $python = env('PYTHON_PATH', 'python');
        $script = base_path('predict.py');
        $modelPath = base_path('models/best.pt');

        $cmd = [$python, $script, $fullImagePath, $outAnnotated, $modelPath];

        Log::info("ProcessDroneImage: running python for detection {$detection->id}", ['cmd' => implode(' ', $cmd)]);

        try {
            $process = new Process($cmd);
            $process->setTimeout(600);
            $process->run();

            $stderr = trim($process->getErrorOutput());
            if ($stderr) {
                Log::warning("ProcessDroneImage: python stderr for id {$detection->id}: " . $stderr);
            }

            if (!$process->isSuccessful()) {
                $errOut = trim($process->getErrorOutput() ?: $process->getOutput());
                Log::error("ProcessDroneImage: python process failed for id {$detection->id}: {$errOut}");
                return;
            }

            $stdout = trim($process->getOutput());
            Log::info("ProcessDroneImage: python stdout for id {$detection->id}: " . (strlen($stdout) > 300 ? substr($stdout,0,300) . '...' : $stdout));

            // --- Robust parse of JSON contained in stdout ---
            $parsed = null;
            if (!empty($stdout)) {
                // try decode directly first (if pure json)
                $try = json_decode($stdout, true);
                if (is_array($try)) {
                    $parsed = $try;
                } else {
                    // attempt to extract last JSON object/array from stdout using regex
                    // This will capture the last brace-enclosed block (works for object or array)
                    if (preg_match_all('/(\{.*\}|\[.*\])\s*$/s', $stdout, $matches)) {
                        $candidate = end($matches[1]);
                        $try2 = json_decode($candidate, true);
                        if (is_array($try2)) {
                            $parsed = $try2;
                        } else {
                            // fallback: find any {...} in stdout and try decode the last one
                            if (preg_match_all('/\{.*?\}/s', $stdout, $allObjMatches)) {
                                $last = end($allObjMatches[0]);
                                $try3 = json_decode($last, true);
                                if (is_array($try3)) $parsed = $try3;
                            }
                        }
                    } else {
                        // last fallback: try to find first "{" and last "}" and substr
                        $first = strpos($stdout, '{');
                        $last = strrpos($stdout, '}');
                        if ($first !== false && $last !== false && $last > $first) {
                            $sub = substr($stdout, $first, $last - $first + 1);
                            $try4 = json_decode($sub, true);
                            if (is_array($try4)) $parsed = $try4;
                        }
                    }
                }
            }

            // If python script wrote a fallback json file, read it
            if ((!is_array($parsed) || empty($parsed)) && file_exists($outJson)) {
                try {
                    $txt = file_get_contents($outJson);
                    $parsed = json_decode($txt, true) ?: $parsed;
                    Log::info("ProcessDroneImage: read predictions json file for id {$detection->id}");
                } catch (\Throwable $e) {
                    Log::warning("ProcessDroneImage: failed reading fallback json file for id {$detection->id}: " . $e->getMessage());
                }
            }

            // if still null make it empty array structure
            if (!is_array($parsed)) $parsed = [];

            // get predictions array from parsed structure (supports a few shapes)
            $preds = [];
            if (isset($parsed['predictions']) && is_array($parsed['predictions'])) {
                $preds = $parsed['predictions'];
            } elseif (isset($parsed['preds']) && is_array($parsed['preds'])) {
                $preds = $parsed['preds'];
            } elseif (is_array($parsed) && array_keys($parsed) === range(0, count($parsed)-1)) {
                // parsed is an array of preds already
                $preds = $parsed;
            }

            // if preds is string try decode
            if (is_string($preds)) {
                $tmp = json_decode($preds, true);
                if (is_array($tmp)) $preds = $tmp;
            }
            if (!is_array($preds)) $preds = [];

            // Save predictions to DB (store as JSON string)
            $detection->predictions = json_encode($preds);

            // compute totals and infected
            $total = count($preds);
            $infected = 0;
            foreach ($preds as $p) {
                $label = strtolower((string)($p['label'] ?? ''));
                $conf = isset($p['confidence']) ? floatval($p['confidence']) : (isset($p['conf']) ? floatval($p['conf']) : 0.0);
                if (strpos($label, 'ganoderma') !== false || $conf >= 0.5) $infected++;
            }

            $detection->total_detected = $total;
            $detection->infected_count = $infected;
            $detection->healthy_count = max(0, $total - $infected);

            // Handle annotated image path: favor the $outAnnotated we've defined,
            // otherwise copy file from script-output absolute path if provided.
            if (file_exists($outAnnotated)) {
                $detection->annotated_path = 'annotated/' . basename($outAnnotated);
            } else {
                $annotPathFromScript = $parsed['annotated_path'] ?? ($parsed['annotated'] ?? null);
                if (!empty($annotPathFromScript) && file_exists($annotPathFromScript)) {
                    $destRel = 'annotated/' . basename($annotPathFromScript);
                    $destFull = storage_path('app/public/' . $destRel);
                    if (!file_exists(dirname($destFull))) mkdir(dirname($destFull), 0755, true);
                    if (@copy($annotPathFromScript, $destFull)) {
                        $detection->annotated_path = $destRel;
                        Log::info("ProcessDroneImage: copied annotated image from script for id {$detection->id}");
                    } else {
                        Log::warning("ProcessDroneImage: failed to copy annotated image from script for id {$detection->id}");
                    }
                } else {
                    Log::info("ProcessDroneImage: no annotated image generated for id {$detection->id}");
                }
            }

            // Write fallback JSON next to annotated file so next attempt can read it
            try {
                $fallback = [
                    'ok' => true,
                    'predictions' => $preds,
                    'infected' => ($infected > 0) ? 1 : 0,
                    'annotated_path' => file_exists($outAnnotated) ? $outAnnotated : ($parsed['annotated_path'] ?? null),
                ];
                file_put_contents($outJson, json_encode($fallback, JSON_PRETTY_PRINT));
            } catch (\Throwable $e) {
                Log::warning("ProcessDroneImage: failed writing fallback json for id {$detection->id}: " . $e->getMessage());
            }

            // fallback: if block not found at upload time, try parse from original filename
            if (empty($detection->block) && !empty($imagePath)) {
                $base = basename($imagePath);
                // original filename might be encoded in the stored name? if not, we try filename from parsed stdout
                $block = null;
                // try to extract from parsed structure if python script returned original_filename
                if (!empty($parsed['original_filename'])) {
                    $block = (new \App\Http\Controllers\DetectController)->extractBlockFromFilename($parsed['original_filename']);
                }
                if (!$block) {
                    // try from stored name (may not contain info if randomized), skip if random
                    $block = (new \App\Http\Controllers\DetectController)->extractBlockFromFilename($base);
                }
                if ($block) $detection->block = $block;
            }

            $detection->save();

            // emit event (non-blocking)
            try {
                event(new \App\Events\DetectionCreated($detection));
            } catch (\Throwable $e) {
                Log::warning("ProcessDroneImage: DetectionCreated event failed for {$detection->id}: " . $e->getMessage());
            }

            Log::info("ProcessDroneImage: finished processing detection {$detection->id} (total={$total}, infected={$infected})");

        } catch (\Throwable $e) {
            Log::error("ProcessDroneImage exception for id {$this->detectionId}: " . $e->getMessage());
            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("ProcessDroneImage failed for id {$this->detectionId}: " . $exception->getMessage());
        try {
            $d = DroneDetection::find($this->detectionId);
            if ($d) {
                $d->predictions = json_encode([]);
                $d->total_detected = 0;
                $d->infected_count = 0;
                $d->save();
            }
        } catch (\Throwable $e) {
            Log::warning("ProcessDroneImage failed() handler also errored: " . $e->getMessage());
        }
    }
}
