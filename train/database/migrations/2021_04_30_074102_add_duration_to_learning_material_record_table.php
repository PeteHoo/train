<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurationToLearningMaterialRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learning_material_record', function (Blueprint $table) {
            //
            $table->integer('duration')->default(0)->comment('学习时长');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('learning_material_record', function (Blueprint $table) {
            //
            $table->dropColumn('duration');
        });
    }
}
