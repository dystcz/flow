<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create(Config::get('flow.steps.edges.table_name'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('start_vertex');
            $table->unsignedBigInteger('end_vertex');
            $table->unsignedBigInteger('path_count');
            $table->unsignedTinyInteger('edge_type');
            $table->timestamps();
            $table->unique(['start_vertex', 'end_vertex']);
            $table->index(['end_vertex']);

            // $table->foreign('start_vertex')->on('my_table')->references('id')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            // $table->foreign('end_vertex')->on('my_table')->references('id')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(Config::get('flow.steps.edges.table_name'));
    }
};
