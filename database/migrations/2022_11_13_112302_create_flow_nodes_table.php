<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
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
        Schema::create(Config::get('flow.nodes.table_name'), function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('template_id');
            $table->foreign('template_id')->references('id')->on(Config::get('flow.templates.table_name'));

            // Handler class
            $table->string('handler');

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
        Schema::dropIfExists(Config::get('flow.nodes.table_name'));
    }
};
