<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLearningMaterialDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_material_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('')->comment('标题');
            $table->integer('learning_material_id')->index()->comment('章节');
            $table->integer('chapter_id')->index()->comment('章节');
            $table->string('description')->nullable()->comment('描述');
            $table->string('video')->nullable()->comment('视频');
            $table->integer('sort')->default('0')->nullable()->comment('排序');
            $table->time('duration')->default('0')->nullable()->comment('时长');
            $table->tinyInteger('is_open')->default('0')->comment('是否开放');
            $table->tinyInteger('status')->default('0')->comment('状态');
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
        Schema::dropIfExists('learning_material_details');
    }
}
