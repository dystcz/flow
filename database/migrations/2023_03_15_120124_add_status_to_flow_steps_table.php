<?php

use Dystcz\Flow\Domain\Flows\Enums\StepStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('flow_steps', function (Blueprint $table) {
            $table->string('status')->default(StepStatus::OPEN->value)->after('group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flow_steps', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
