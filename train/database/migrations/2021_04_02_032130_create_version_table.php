<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('version', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('name')->default(0)->comment('名称');
            $table->tinyInteger('os')->comment('终端（1-android 2-ios）');
            $table->string('version_code')->default('')->comment('版本号');
            $table->tinyInteger('status')->default('0')->comment('状态(0-关闭 1-开启)');
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
        Schema::dropIfExists('version');
    }
}
