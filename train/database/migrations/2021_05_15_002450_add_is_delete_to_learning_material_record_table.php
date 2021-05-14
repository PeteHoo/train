<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDeleteToLearningMaterialRecordTable extends Migration
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
            $table->tinyInteger('is_delete')->default(0)->comment('是否删除');
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
            $table->dropColumn('is_delete');
        });
    }
}
