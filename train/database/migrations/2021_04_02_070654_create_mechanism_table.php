<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMechanismTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mechanism', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('名称');
            $table->string('social_credit_code')->default('')->comment('社会信用代码');
            $table->string('address')->default('')->comment('地址');
            $table->string('deposit_bank')->default('')->comment('开户行');
            $table->string('bank_card_number')->default('')->comment('银行卡号');
            $table->string('legal_person')->default('')->comment('法人');
            $table->string('id_card')->default('')->comment('证件号码');
            $table->string('phone')->default('')->comment('手机号');
            $table->tinyInteger('status')->default('0')->comment('status');
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
        Schema::dropIfExists('mechanism');
    }
}
