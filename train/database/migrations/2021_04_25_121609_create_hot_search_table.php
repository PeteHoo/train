<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot_search', function (Blueprint $table) {
            $table->increments('id');
            $table->string('words')->default('')->comment('搜索词语');
            $table->integer('count')->default('0')->comment('搜索次数');
            $table->integer('sort')->default('0')->comment('排序');
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
        Schema::dropIfExists('hot_search');
    }
}
