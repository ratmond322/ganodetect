 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetectionStatsToDroneDetections extends Migration
{
    public function up()
    {
        Schema::table('drone_detections', function (Blueprint $table) {
            if (!Schema::hasColumn('drone_detections', 'predictions')) {
                $table->text('predictions')->nullable()->after('image_path');
            }
            if (!Schema::hasColumn('drone_detections', 'total_detected')) {
                $table->unsignedInteger('total_detected')->nullable()->after('predictions');
            }
            if (!Schema::hasColumn('drone_detections', 'infected_count')) {
                $table->unsignedInteger('infected_count')->nullable()->after('total_detected');
            }
            if (!Schema::hasColumn('drone_detections', 'healthy_count')) {
                $table->unsignedInteger('healthy_count')->nullable()->after('infected_count');
            }
            if (!Schema::hasColumn('drone_detections', 'annotated_path')) {
                $table->string('annotated_path')->nullable()->after('predictions');
            }
        });
    }

    public function down()
    {
        Schema::table('drone_detections', function (Blueprint $table) {
            $table->dropColumn(['predictions','total_detected','infected_count','healthy_count','annotated_path']);
        });
    }
}
