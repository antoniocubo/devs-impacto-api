<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $columnsToDrop = array_filter(
            ['status', 'priority'],
            fn (string $column) => Schema::hasColumn('posts', $column)
        );

        if (! empty($columnsToDrop)) {
            Schema::table('posts', function (Blueprint $table) use ($columnsToDrop) {
                $table->dropColumn($columnsToDrop);
            });
        }

        if (! Schema::hasColumn('posts', 'audio_url')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('audio_url');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('posts', 'audio_url')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('audio_url');
            });
        }

        if (! Schema::hasColumn('posts', 'status')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('status')->after('content');
            });
        }

        if (! Schema::hasColumn('posts', 'priority')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('priority')->after('status');
            });
        }
    }
};
