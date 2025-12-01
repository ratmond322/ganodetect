<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DroneDetection;
use Illuminate\Support\Facades\Storage;

class DetectionController extends Controller
{
    /**
     * Tampilkan semua hasil deteksi.
     */
    public function index()
    {
        $detections = DroneDetection::orderBy('created_at', 'desc')->paginate(12);

        return view('detections.index', compact('detections'));
    }

    /**
     * Tampilkan satu detail deteksi.
     */
    public function show($id)
    {
        $detection = DroneDetection::findOrFail($id);

        // decode predictions supaya bisa ditampilkan
        $predictions = json_decode($detection->predictions ?? '[]', true);

        return view('detections.show', compact('detection', 'predictions'));
    }

    /**
     * Hapus deteksi beserta file storagenya.
     */
    public function destroy($id)
    {
        $detection = DroneDetection::findOrFail($id);

        // hapus file asli
        if ($detection->image_path) {
            Storage::disk('public')->delete($detection->image_path);
        }

        // hapus annotated
        if ($detection->annotated_path) {
            Storage::disk('public')->delete($detection->annotated_path);
        }

        // hapus thumbnail jika ada
        if ($detection->thumbnail_path) {
            Storage::disk('public')->delete($detection->thumbnail_path);
        }

        $detection->delete();

        return redirect()->route('detections.index')->with('success', 'Deteksi berhasil dihapus.');
    }
}
