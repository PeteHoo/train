<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourceMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('source_material', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('素材名称');
            $table->string('picture')->nullable()->comment('缩略图');
            $table->integer('type')->comment('类型（1-视频 2-视频 3-模型）');
            $table->string('file_url')->nullable()->comment('文件路径');
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
        Schema::dropIfExists('source_material');
    }
}
