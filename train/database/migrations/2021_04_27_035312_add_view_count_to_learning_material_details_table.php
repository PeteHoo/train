<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewCountToLearningMaterialDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learning_material_details', function (Blueprint $table) {
            //
            $table->integer('view_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('learning_material_details', function (Blueprint $table) {
            //
            $table->dropColumn('view_count');
        });
    }
}
