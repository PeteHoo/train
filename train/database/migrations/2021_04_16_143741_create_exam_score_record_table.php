<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamScoreRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_score_record', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->default('')->comment('用户');
            $table->integer('exam_id')->comment('试题');
            $table->integer('score')->comment('分数');
            $table->integer('question_count')->comment('题目数量');
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
        Schema::dropIfExists('exam_score_record');
    }
}
