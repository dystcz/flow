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
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Config::get('flow.steps.users.table_name'), function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('step_id')->nullable();
            $table->foreign('step_id')->references('id')->on(Config::get('flow.steps.table_name'));

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on(Config::get('flow.users.table_name'));

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Config::get('flow.steps.users.table_name'));
    }
};
