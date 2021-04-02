<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdatePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('update_plan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('name')->default('0')->comment('app名称');
            $table->string('md5')->nullable()->comment('加密');
            $table->string('download_link')->nullable()->comment('下载链接');
            $table->string('description')->nullable()->comment('描述');
            $table->integer('after_version')->comment('更新后版本');
            $table->string('before_version')->default('')->comment('更新前版本');
            $table->tinyInteger('status')->default('0')->nullable()->comment('状态');
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
        Schema::dropIfExists('update_plan');
    }
}
