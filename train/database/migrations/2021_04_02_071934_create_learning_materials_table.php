<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLearningMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('')->comment('标题');
            $table->string('description')->nullable()->comment('描述');
            $table->integer('industry_id')->comment('行业');
            $table->integer('occupation_id')->comment('职业');
            $table->integer('mechanism_id')->comment('机构');
            $table->string('picture')->nullable()->comment('视频预览图');
            $table->tinyInteger('status')->default('0')->comment('状态');
            $table->integer('sort')->default('0')->comment('排序');
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
        Schema::dropIfExists('learning_materials');
    }
}
