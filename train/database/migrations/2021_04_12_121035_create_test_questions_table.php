<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->default('1')->comment('类型（1-选择题 2-判断题）');
            $table->integer('attributes')->comment('属性（1-文本 2-图片）');
            $table->longText('description')->nullable()->comment('描述');
            $table->string('description_image')->nullable()->comment('图片描述');
            $table->text('answer_single_option')->nullable()->comment('选择题选项');
            $table->text('answer_judgment_option')->nullable()->comment('判断题选项');
            $table->string('true_single_answer')->nullable()->comment('选择题正确答案');
            $table->string('true_judgment_answer')->nullable()->comment('判断题正确答案');
            $table->string('mechanism_id')->nullable()->comment('机构id');
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
        Schema::dropIfExists('test_questions');
    }
}
