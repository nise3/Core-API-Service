<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institute_permissions', function (Blueprint $table) {
            $table->unsignedInteger('institute_id');
            $table->unsignedInteger('permission_id');
            $table->primary(['institute_id', 'permission_id'], 'institute_permissions_institute_id_permission_id_primary')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('institute_permissions');
    }
}
