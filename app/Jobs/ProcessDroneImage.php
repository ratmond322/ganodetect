<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\DroneDetection;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessDroneImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $detectionId;
    public $userId;

    public function __construct(int $detectionId, $userId = null)
    {
        $this->detectionId = $detectionId;
        $this->userId = $userId;
    }

    public function handle()
    {
        $d = DroneDetection::find($this->detectionId);
        if (!$d) {
            Log::error("ProcessDroneImage: detection not found {$this->detectionId}");
            return;
        }

        $inputPath = storage_path('app/' . $d->image_path);
        if (!file_exists($inputPath)) {
            // fallback to storage/app/public/<path>
            $inputPathPublic = storage_path('app/public/' . $d->image_path);
            if (file_exists($inputPathPublic)) {
                $inputPath = $inputPathPublic;
            }
        }

        $outDir = storage_path('app/public/annotated');
        if (!is_dir($outDir)) @mkdir($outDir, 0755, true);
        $outFilename = 'annotated_' . pathinfo($inputPath, PATHINFO_FILENAME) . '.jpg';
        $outputPath = $outDir . DIRECTORY_SEPARATOR . $outFilename;

        $python = env('PYTHON_BIN', 'python');
        $script = base_path('predict.py');
        $modelPath = base_path(env('MODEL_PATH', 'models/best.pt'));

        $cmd = [$python, $script, $inputPath, $outputPath, $modelPath];

        Log::info("[ProcessDroneImage-debug] cmd: " . implode(' ', $cmd));

        $process = new Process($cmd);
        $process->setTimeout(300);

        try {
            $process->run();

            Log::info("[ProcessDroneImage-debug] exitCode: " . $process->getExitCode());
            Log::info("[ProcessDroneImage-debug] raw_stdout: " . $process->getOutput());
            Log::info("[ProcessDroneImage-debug] raw_stderr: " . $process->getErrorOutput());

            if (!$process->isSuccessful()) {
                Log::error("[ProcessDroneImage-debug] process not successful");
                return;
            }

            // --- Robust JSON extraction: find JSON object that starts with {"ok"
            $rawStdout = $process->getOutput();
            $rawStderr = $process->getErrorOutput();

            $jsonString = null;

            // prefer explicit marker
            $marker = '{"ok"';
            $pos = strpos($rawStdout, $marker);
            if ($pos !== false) {
                $jsonString = substr($rawStdout, $pos);
            } else {
                // try stderr
                $pos2 = strpos($rawStderr, $marker);
                if ($pos2 !== false) {
                    $jsonString = substr($rawStderr, $pos2);
                } else {
                    // fallback: regex attempt to capture last {...} block
                    if (preg_match('/\{.*"ok".*\}/s', $rawStdout, $m)) {
                        $jsonString = $m[0];
                    } elseif (preg_match('/\{.*"ok".*\}/s', $rawStderr, $m2)) {
                        $jsonString = $m2[0];
                    } else {
                        // last resort: try last '{' to end (previous approach)
                        $pos3 = strrpos($rawStdout, '{');
                        if ($pos3 !== false) $jsonString = substr($rawStdout, $pos3);
                    }
                }
            }

            \Log::info("[ProcessDroneImage-debug] raw_stdout: " . $rawStdout);
            \Log::info("[ProcessDroneImage-debug] raw_stderr: " . $rawStderr);
            \Log::info("[ProcessDroneImage-debug] extracted_json: " . ($jsonString ?? 'NULL'));

            $data = null;
            if ($jsonString !== null) {
                $data = json_decode($jsonString, true);
            }

            if (json_last_error() !== JSON_ERROR_NONE || $data === null) {
                \Log::error("[ProcessDroneImage-debug] json decode failed: " . json_last_error_msg());
                \Log::error("[ProcessDroneImage-debug] raw stdout: " . $rawStdout);
                \Log::error("[ProcessDroneImage-debug] raw stderr: " . $rawStderr);
                $data = [];
            }


            $predictions = $data['predictions'] ?? null;
            $infected = $data['infected'] ?? 0;
            $annotated_abs = $data['annotated_path'] ?? null;

            // copy annotated file into storage/public/annotated if path exists
            if ($annotated_abs && file_exists($annotated_abs)) {
                if (!file_exists(dirname($outputPath))) @mkdir(dirname($outputPath), 0755, true);
                copy($annotated_abs, $outputPath);
                Log::info("[ProcessDroneImage-debug] copied annotated from $annotated_abs to $outputPath");
            } elseif (file_exists($outputPath)) {
                Log::info("[ProcessDroneImage-debug] outputPath exists: $outputPath");
            } else {
                Log::warning("[ProcessDroneImage-debug] no annotated output found at $annotated_abs or $outputPath");
            }

            // === Normalize predictions: ensure array ===
            if (is_array($predictions)) {
                $predArr = $predictions;
            } elseif ($predictions === null) {
                $predArr = [];
            } else {
                $maybe = @json_decode($predictions, true);
                $predArr = is_array($maybe) ? $maybe : [];
            }

            // === Normalize infected flag ===
            $infectedVal = $infected ?? 0;
            $infectedFlag = 0;
            if ($infectedVal === true || $infectedVal === 1 || $infectedVal === "1" || (is_numeric($infectedVal) && intval($infectedVal) > 0)) {
                $infectedFlag = 1;
            } elseif (count($predArr) > 0) {
                $infectedFlag = 1;
            }

            // Save to model: predictions as JSON string (or null)
            try {
                $d->predictions = count($predArr) > 0 ? json_encode($predArr, JSON_UNESCAPED_UNICODE) : null;
                $d->infected = $infectedFlag;

                // store the relative path under storage/public only if the annotated file exists
                if (file_exists($outputPath)) {
                    $d->annotated_path = 'annotated/' . $outFilename;
                }

                $d->save();

                Log::info("[ProcessDroneImage-debug] saved detection " . $d->id
                    . " (pred_count=" . count($predArr)
                    . ", infected=" . $d->infected
                    . ", annotated_path=" . ($d->annotated_path ?? 'NULL') . ")");
            } catch (\Exception $e) {
                Log::error("[ProcessDroneImage-debug] save failed: " . $e->getMessage());
            }
        } catch (\Exception $e) {
            Log::error("[ProcessDroneImage-debug] exception: " . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}
