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
        Schema::create('process_nodes', function (Blueprint $table) {
            $table->id();

            // ProcessTemplate relationship
            $table->unsignedBigInteger('process_template_id');
            $table->foreign('process_template_id')->references('id')->on('process_templates');

            // Handler class
            $table->string('handler_type');

            $table->string('name');
            $table->string('key');
            $table->string('group');

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
        Schema::dropIfExists('process_nodes');
    }
};
