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

            $table->unsignedTinyInteger('user_type')->comment('TBA');
            $table->string('username', 100);

            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedSmallInteger('role_id')->nullable();

            $table->string('name_en', 255);
            $table->string('name_bn', 300)->nullable();

            $table->string('email', 191);
            $table->string('mobile', 15)->nullable();

            $table->unsignedMediumInteger('loc_division_id')->nullable()->index('users_loc_division_id_inx');
            $table->unsignedMediumInteger('loc_district_id')->nullable()->index('users_loc_district_id_inx');
            $table->unsignedMediumInteger('loc_upazila_id')->nullable()->index('users_loc_upazila_id_inx');

            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
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
