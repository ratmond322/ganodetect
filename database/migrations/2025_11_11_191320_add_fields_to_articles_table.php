<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'author')) {
                $table->string('author')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('articles', 'image')) {
                $table->string('image')->nullable()->after('author');
            }
            if (!Schema::hasColumn('articles', 'excerpt')) {
                $table->string('excerpt', 500)->nullable()->after('image');
            }
            if (!Schema::hasColumn('articles', 'body')) {
                $table->longText('body')->nullable()->after('excerpt');
            }
            if (!Schema::hasColumn('articles', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('body');
            }
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            foreach (['published_at','body','excerpt','image','author'] as $col) {
                if (Schema::hasColumn('articles', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
