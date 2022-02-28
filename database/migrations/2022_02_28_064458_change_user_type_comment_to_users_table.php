<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUserTypeCommentToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('user_type')->comment('1 => system user, 2 => organization user, 3 => institute user, 4 => youth user, 5 => industry association user, 6 => rto user')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('user_type')->comment('1 => system user, 2 => organization user, 3 => institute user, 4 => youth user, 5 => industry association user, 6 => trainer user, 7 => rto user')->change();
        });
    }
}
