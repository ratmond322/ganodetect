<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToDroneDetectionsTable extends Migration
{
    public function up()
    {
        Schema::table('drone_detections', function (Blueprint $table) {
            $table->string('status', 50)->default('processing')->after('image_path');
        });
    }

    public function down()
    {
        Schema::table('drone_detections', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
