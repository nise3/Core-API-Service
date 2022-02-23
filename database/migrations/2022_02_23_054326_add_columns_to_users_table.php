<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('user_type')->comment('1 => system user, 2 => organization user, 3 => institute user, 4 => youth user, 5 => industry association user, 6 => trainer user, 7 => rto user')->change();
            $table->unsignedInteger('trainer_id')->nullable()->after('industry_association_id');
            $table->unsignedInteger('registered_training_organization_id')->nullable()->after('trainer_id');
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
            $table->dropColumn('trainer_id');
            $table->dropColumn('registered_training_organization_id');
        });
    }
}
