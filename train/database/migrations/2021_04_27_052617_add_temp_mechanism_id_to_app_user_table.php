<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTempMechanismIdToAppUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_user', function (Blueprint $table) {
            //
            $table->integer('temp_mechanism_id')->nullable()->default(0)->comment('临时机构id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_user', function (Blueprint $table) {
            //
            $table->dropColumn('temp_mechanism_id');
        });
    }
}
