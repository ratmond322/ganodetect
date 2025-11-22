<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('drone_detections', function (Blueprint $table) {
            if (! Schema::hasColumn('drone_detections', 'annotated_path')) {
                $table->string('annotated_path')->nullable()->after('infected');
            }
        });
    }

    public function down()
    {
        Schema::table('drone_detections', function (Blueprint $table) {
            if (Schema::hasColumn('drone_detections', 'annotated_path')) {
                $table->dropColumn('annotated_path');
            }
        });
    }
};
