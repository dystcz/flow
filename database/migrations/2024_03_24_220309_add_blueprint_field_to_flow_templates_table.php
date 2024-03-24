<?php

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
        Schema::table(Config::get('flow.templates.table_name'), function (Blueprint $table) {
            $table->string('blueprint')->nullable()->after('model_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(Config::get('flow.templates.table_name'), function (Blueprint $table) {
            $table->dropColumn('blueprint');
        });
    }
};
