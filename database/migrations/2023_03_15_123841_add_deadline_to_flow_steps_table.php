<?php

declare(strict_types=1);

use Dystcz\Flow\Domain\Flows\Models\Step;
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
            $table->dateTime('deadline')->after(Step::stepAttributesField())->nullable();
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
            $table->dropColumn('deadline');
        });
    }
};
