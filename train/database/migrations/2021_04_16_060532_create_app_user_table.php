<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->default('')->comment('用户id');
            $table->string('name')->nullable()->comment('用户名');
            $table->string('nick_name')->nullable()->comment('用户昵称');
            $table->string('phone')->default('')->comment('手机号');
            $table->tinyInteger('sex')->nullable()->comment('性别');
            $table->date('birthday')->nullable()->comment('生日');
            $table->string('password')->nullable()->comment('密码');
            $table->integer('attribute')->nullable()->comment('属性');
            $table->string('avatar')->nullable()->comment('头像');
            $table->integer('mechanism_id')->nullable()->default('0')->comment('机构');
            $table->string('industry_id')->nullable()->comment('行业集合');
            $table->string('occupation_id')->nullable()->comment('职业集合');
            $table->string('token')->nullable()->default('')->comment('token');
            $table->tinyInteger('status')->default(0)->comment('状态');
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
        Schema::dropIfExists('app_user');
    }
}
