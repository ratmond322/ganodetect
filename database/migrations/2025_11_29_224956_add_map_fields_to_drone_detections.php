<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('drone_detections', function (Blueprint $table) {
            $table->decimal('lat', 10, 7)->nullable()->after('annotated_path');
            $table->decimal('lng', 10, 7)->nullable()->after('lat');
            $table->string('block')->nullable()->after('lng');
            $table->float('confidence')->nullable()->after('predictions');
        });
    }

    public function down()
    {
        Schema::table('drone_detections', function (Blueprint $table) {
            $table->dropColumn(['lat','lng','block','confidence']);
        });
    }

};
