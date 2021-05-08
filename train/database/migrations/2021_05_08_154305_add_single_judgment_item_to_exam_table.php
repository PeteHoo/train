<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSingleJudgmentItemToExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam', function (Blueprint $table) {
            //
            $table->text('single_item')->nullable()->comment('判断题集合');
            $table->text('judgment_item')->nullable()->comment('判断题集合');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam', function (Blueprint $table) {
            //
            $table->dropColumn('single_item');
            $table->dropColumn('judgment_item');
        });
    }
}
