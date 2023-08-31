<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(Config::get('flow.steps.table_name'), function (Blueprint $table) {
            $table->dateTime('skipped_at')->nullable()->after('finished_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(Config::get('flow.steps.table_name'), function (Blueprint $table) {
            $table->dropColumn('skipped_at');
        });
    }
};
