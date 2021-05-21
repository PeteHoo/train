<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributeToTestQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_questions', function (Blueprint $table) {
            //
            $table->tinyInteger('temp_is_open')->nullable()->default(0)->comment('临时开放');
            $table->longText('temp_description')->nullable()->comment('临时描述');
            $table->string('temp_description_image')->nullable()->comment('临时图片描述');
            $table->text('temp_answer_single_option')->nullable()->comment('临时选择题选项');
            $table->string('temp_true_single_answer')->nullable()->comment('临时选择题正确答案');
            $table->string('temp_true_judgment_answer')->nullable()->comment('临时判断题正确答案');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_questions', function (Blueprint $table) {
            //
            $table->dropColumn('temp_is_open');
            $table->dropColumn('temp_description');
            $table->dropColumn('temp_description_image');
            $table->dropColumn('temp_answer_single_option');
            $table->dropColumn('temp_true_single_answer');
            $table->dropColumn('temp_true_judgment_answer');
        });
    }
}
