<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DroneDetection extends Model
{
    // app/Models/DroneDetection.php
    protected $fillable = ['user_id','image_path','predictions','infected','annotated_path'];
    protected $casts = [
    'predictions' => 'array',
    'infected' => 'boolean'
    ];


    // database/migrations/2025_xx_xx_create_drone_detections_table.php
    public function up()
    {
        Schema::create('drone_detections', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->string('status')->default('processing');
            $table->text('predictions')->nullable(); // store JSON string
            $table->timestamps();
        });
    }

}

