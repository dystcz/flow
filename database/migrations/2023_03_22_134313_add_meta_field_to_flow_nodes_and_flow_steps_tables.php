<?php

declare(strict_types=1);

use Dystcz\Flow\Domain\Flows\Models\Step;
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
            $table->json('meta')->after(Step::stepAttributesField())->nullable();
        });

        Schema::table(Config::get('flow.nodes.table_name'), function (Blueprint $table) {
            $table->json('meta')->after('group')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(Config::get('flow.steps.table_name'), function (Blueprint $table) {
            $table->dropColumn('meta');
        });

        Schema::table(Config::get('flow.nodes.table_name'), function (Blueprint $table) {
            $table->dropColumn('meta');
        });
    }
};
