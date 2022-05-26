<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForgetPasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forget_password_resets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idp_user_id')->unique();
            $table->string('username');
            $table->char('otp_code', 6)->nullable();
            $table->dateTime('otp_code_sent_at')->nullable();
            $table->dateTime('otp_code_verified_at')->nullable();
            $table->dateTime('password_reset_at')->nullable();
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
        Schema::dropIfExists('forget_password_resets');
    }
}
