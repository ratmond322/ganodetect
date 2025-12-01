<?php
namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\DroneDetection;

class DetectionCreated
{
    use Dispatchable, SerializesModels;

    public $detection;

    public function __construct(DroneDetection $detection)
    {
        $this->detection = $detection;
    }
}
