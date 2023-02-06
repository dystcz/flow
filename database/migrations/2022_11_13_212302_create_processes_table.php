<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');

            // ProcessTemplate relationship
            $table->unsignedBigInteger('process_template_id')->nullable();
            $table->foreign('process_template_id')->references('id')->on('process_templates');

            // ProcessNode relation
            $table->unsignedBigInteger('process_node_id');
            $table->foreign('process_node_id')->references('id')->on('process_nodes');

            // Handler class
            $table->string('handler_type');

            $table->string('name');
            $table->string('key');

            $table->string('group');

            $table->dateTime('closed_at')->nullable();
            $table->dateTime('finished_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processes');
    }
};
