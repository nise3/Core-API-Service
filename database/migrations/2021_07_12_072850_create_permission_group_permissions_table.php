<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionGroupPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_group_permissions', function (Blueprint $table) {
            $table->unsignedInteger('permission_group_id');
            $table->unsignedInteger('permission_id');
            $table->primary(['permission_group_id','permission_id'], 'permission_group_permissions_permission_group_id_permission_id_primary')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permission_group_permissions');
    }
}
