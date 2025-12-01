<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DroneDetection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardDataController extends Controller
{
    public function stats()
    {
        $total = (int) DroneDetection::count();
        $priority = (int) DroneDetection::where('infected_count', '>', 0)->count();
        $activeDrones = (int) DroneDetection::distinct()->count('user_id');

        $healthyPct = $total ? round((1 - ($priority / $total)) * 100, 1) . '%' : '100%';

        return response()->json([
            'total'    => $total,
            'drones'   => $activeDrones,
            'healthy'  => $healthyPct,
            'priority' => $priority,
        ]);
    }

    public function recent(Request $request)
    {
        $afterId = $request->query('after_id');

        $query = DroneDetection::orderBy('id', 'desc')->take(10);

        if ($afterId) {
            $query = DroneDetection::where('id', '>', (int) $afterId)
                ->orderBy('id', 'desc')
                ->take(20);
        }

        $rows = $query->get()->map(function ($d) {
            $preds = json_decode($d->predictions ?? "[]", true);
            $total = $d->total_detected ?? (is_array($preds) ? count($preds) : 0);
            $infected = $d->infected_count ?? null;
            if($infected === null) {
                // compute fallback
                $infected = 0;
                if(is_array($preds)) {
                    foreach ($preds as $p) {
                        $flag = $p['infected'] ?? $p['is_infected'] ?? false;
                        $conf = isset($p['confidence']) ? floatval($p['confidence']) : 0;
                        $label = strtolower($p['label'] ?? '');
                        if($flag === 1 || $flag === true) { $infected++; continue; }
                        if(str_contains($label, 'ganoderma') && $conf >= 0.5) { $infected++; continue; }
                        if($conf >= 0.85) { $infected++; continue; }
                    }
                }
            }
            $healthy = max(0, $total - (int)$infected);

            return [
                'id'    => $d->id,
                'title' => "Deteksi #{$d->id}",
                'time'  => $d->created_at->diffForHumans(),
                'created_at' => $d->created_at->toIso8601String(),
                'total_detected' => (int)$total,
                'infected_count' => (int)$infected,
                'healthy_count' => (int)$healthy,
                'predictions' => is_array($preds) ? $preds : [],
                'thumbnail_url' => $d->annotated_path ? asset('storage/'.$d->annotated_path) : ($d->image_path ? asset('storage/'.$d->image_path) : null),
                'lat' => $d->lat,
                'lng' => $d->lng,
                'block' => $d->block,
            ];
        });

        return response()->json($rows);
    }

    public function trend(Request $request)
    {
        $days = (int) $request->query('days', 7);
        $start = Carbon::today()->subDays($days - 1)->startOfDay();

        $data = DroneDetection::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', $start)
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date')
        ->get()
        ->keyBy('date');

        $labels = [];
        $values = [];
        for ($i = 0; $i < $days; $i++) {
            $d = $start->copy()->addDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($d)->format('D');
            $values[] = isset($data[$d]) ? (int)$data[$d]->count : 0;
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values,
        ]);
    }

    public function distribution()
    {
        $low = 0; $med = 0; $high = 0;
        $all = DroneDetection::select('infected_count', 'predictions')->get();

        foreach ($all as $r) {
            $infected = $r->infected_count ?? null;
            if($infected !== null){
                if($infected === 0) $low++;
                elseif($infected < 3) $med++;
                else $high++;
                continue;
            }
            $preds = json_decode($r->predictions ?? "[]", true);
            if (is_array($preds) && count($preds)) {
                $top = $preds[0]['confidence'] ?? 0;
                if ($top >= 0.75) $high++;
                elseif ($top >= 0.5) $med++;
                else $low++;
            } else {
                $low++;
            }
        }

        return response()->json([
            'labels' => ['Rendah','Sedang','Tinggi'],
            'values' => [$low, $med, $high],
        ]);
    }

    public function areaCoverage()
    {
        $rows = DroneDetection::select('block', DB::raw('COUNT(*) as scanned'), DB::raw('SUM(infected_count) as infected'))
            ->groupBy('block')
            ->get();

        $labels = $rows->pluck('block')->map(fn($b) => $b ?? 'Unknown')->toArray();
        $treesScanned = $rows->pluck('scanned')->map(fn($v) => (int)$v)->toArray();
        $infected = $rows->pluck('infected')->map(fn($v) => (int)$v)->toArray();

        // if empty, provide a default so frontend doesn't break
        if(empty($labels)) {
            $labels = ['Unknown'];
            $treesScanned = [0];
            $infected = [0];
        }

        return response()->json([
            'labels' => $labels,
            'treesScanned' => $treesScanned,
            'infected' => $infected,
        ]);
    }

    public function droneLocations()
    {
        $rows = DroneDetection::whereNotNull('lat')->whereNotNull('lng')
            ->orderBy('created_at', 'desc')->take(50)->get(['id','lat','lng','block','created_at','predictions']);

        $out = $rows->map(function($r){
            $preds = json_decode($r->predictions ?? "[]", true);
            return [
                'id' => $r->id,
                'lat' => (float)$r->lat,
                'lng' => (float)$r->lng,
                'block' => $r->block,
                'time' => $r->created_at->toIso8601String(),
                'predictions' => $preds,
            ];
        });

        return response()->json($out);
    }
}
