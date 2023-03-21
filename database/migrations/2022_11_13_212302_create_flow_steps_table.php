<?php

declare(strict_types=1);

use Dystcz\Flow\Domain\Flows\Models\Step;
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
        Schema::create(Config::get('flow.steps.table_name'), function (Blueprint $table) {
            $table->id();
            $table->morphs('model');

            // Template relationship
            $table->unsignedBigInteger('template_id')->nullable();
            $table->foreign('template_id')->references('id')->on(Config::get('flow.templates.table_name'));

            // Node relation
            $table->unsignedBigInteger('node_id');
            $table->foreign('node_id')->references('id')->on(Config::get('flow.nodes.table_name'));

            // Handler class
            $table->string('handler');

            $table->string('name');
            $table->string('key');

            $table->string('group');
            $table->json(Step::stepAttributesField())->nullable();

            $table->dateTime('saved_at')->nullable();
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
        Schema::dropIfExists(Config::get('flow.steps.table_name'));
    }
};
