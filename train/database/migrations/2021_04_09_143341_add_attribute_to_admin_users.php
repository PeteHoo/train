<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributeToAdminUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            //
            $table->string('phone')->comment('手机号');
            $table->tinyInteger('member_type')->comment('会员类型');
            $table->string('company_name')->comment('公司名称');
            $table->string('social_code')->comment('社会编码');
            $table->integer('province')->comment('省');
            $table->integer('city')->comment('市');
            $table->string('address')->comment('地址');
            $table->string('legal_person')->comment('法人');
            $table->string('legal_person_id_card')->comment('法人身份证');
            $table->string('contact_name')->comment('联系人姓名');
            $table->string('contact_phone')->comment('手机号');

            $table->string('payee')->comment('收款方');
            $table->string('bank')->comment('开户行');
            $table->string('bank_address')->comment('开户行所在地');
            $table->string('bank_account')->comment('银行账户');
            $table->string('bank_account_confirmation')->comment('账号确认');

            $table->string('business_picture')->comment('营业执照正面');
            $table->string('bank_permit_picture')->comment('营业执照正面');
            $table->tinyInteger('is_permit')->default(0)->comment('是否同意协议');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            //
            $table->dropColumn('phone');
            $table->dropColumn('member_type');
            $table->dropColumn('company_name');
            $table->dropColumn('social_code');
            $table->dropColumn('province');
            $table->dropColumn('city');
            $table->dropColumn('address');
            $table->dropColumn('legal_person');
            $table->dropColumn('legal_person_id_card');
            $table->dropColumn('contact_name');
            $table->dropColumn('contact_phone');

            $table->dropColumn('payee');
            $table->dropColumn('bank');
            $table->dropColumn('bank_address');
            $table->dropColumn('bank_account');
            $table->dropColumn('bank_account_confirm');

            $table->dropColumn('business_picture');
            $table->dropColumn('bank_permit_picture');
            $table->dropColumn('is_permit');
        });
    }
}
