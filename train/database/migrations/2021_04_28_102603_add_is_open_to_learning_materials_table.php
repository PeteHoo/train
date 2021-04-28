<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsOpenToLearningMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learning_materials', function (Blueprint $table) {
            //
            $table->tinyInteger('is_open')->default('0')->comment('是否开放');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('learning_materials', function (Blueprint $table) {
            //
            $table->dropColumn('is_open');
        });
    }
}
