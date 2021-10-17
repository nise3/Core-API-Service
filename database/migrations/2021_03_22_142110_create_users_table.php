<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idp_user_id')->nullable();
            $table->unsignedTinyInteger('user_type')->comment('TBA');
            $table->string('username', 100)->unique();

            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedSmallInteger('role_id')->nullable();

            $table->string('name_en', 255);
            $table->string('name', 300)->nullable();

            $table->string('email', 191);
            $table->string("country")->default("BD");
            $table->string("phone_code")->default("880");
            $table->string('mobile', 11)->nullable();

            $table->unsignedMediumInteger('loc_division_id')
                ->nullable()->index('users_loc_division_id_inx');
            $table->unsignedMediumInteger('loc_district_id')
                ->nullable()->index('users_loc_district_id_inx');
            $table->unsignedMediumInteger('loc_upazila_id')
                ->nullable()->index('users_loc_upazila_id_inx');

            /**
             * $table->timestamp('email_verified_at')->nullable();
             * $table->timestamp('mobile_verified_at')->nullable();
             */
            $table->string("verification_code", 50)->nullable()
                ->comment('Email Or SMS verification code');
            $table->dateTime("verification_code_sent_at")->nullable()
                ->comment('Email Or SMS verification code sent at');
            $table->dateTime("verification_code_verified_at")->nullable()
                ->comment('Email Or SMS verification code verified at');

            $table->string('password', 191);
            $table->string('profile_pic', 1000)->nullable();

            $table->unsignedTinyInteger('row_status')->default(1);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
