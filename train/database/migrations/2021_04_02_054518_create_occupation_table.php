<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccupationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occupation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('名称');
            $table->integer('industry_id')->comment('行业');
            $table->integer('choice_question_num')->default('0')->comment('选择题数量');
            $table->integer('choice_question_score')->default('0')->comment('选择题分数');
            $table->integer('judgment_question_num')->default('0')->comment('判断题数量');
            $table->integer('judgment_question_score')->default('0')->comment('判断题分数');
            $table->integer('exam_time')->default('0')->comment('考试时长（分钟）');
            $table->integer('passing_grade')->default('60')->comment('及格分');
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
        Schema::dropIfExists('occupation');
    }
}
