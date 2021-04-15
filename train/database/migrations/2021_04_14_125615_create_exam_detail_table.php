<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id')->comment('试卷');
            $table->integer('question_id')->comment('题库');
            $table->tinyInteger('type')->comment('题型(1-选择题 2-判断题)');
            $table->integer('sort')->nullable()->comment('排序');
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
        Schema::dropIfExists('exam_detail');
    }
}
