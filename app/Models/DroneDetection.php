<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DroneDetection extends Model
{
    protected $table = 'drone_detections';

    protected $fillable = [
        'user_id',
        'image_path',
        'annotated_path',
        'thumbnail_path',
        'predictions',
        'infected_count',
        'total_detected',
        'healthy_count',
        'lat',
        'lng',
        'block',
        'status',
    ];

    protected $casts = [
        'predictions' => 'array',
        'infected_count' => 'integer',
        'total_detected' => 'integer',
        'healthy_count' => 'integer',
        'lat' => 'float',
        'lng' => 'float',
    ];
}
