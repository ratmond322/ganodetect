<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlockToDetectionsTable extends Migration
{
    public function up()
    {
        // targetkan tabel yang benar
        if (Schema::hasTable('drone_detections')) {
            Schema::table('drone_detections', function (Blueprint $table) {
                if (!Schema::hasColumn('drone_detections', 'block')) {
                    $table->string('block')->nullable()->after('image_url');
                }
            });
        } else {
            // opsional: buat tabel minimal (jarang diperlukan)
            Schema::create('drone_detections', function (Blueprint $table) {
                $table->id();
                $table->string('image_url')->nullable();
                $table->string('block')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('drone_detections') && Schema::hasColumn('drone_detections', 'block')) {
            Schema::table('drone_detections', function (Blueprint $table) {
                $table->dropColumn('block');
            });
        }
    }
}

