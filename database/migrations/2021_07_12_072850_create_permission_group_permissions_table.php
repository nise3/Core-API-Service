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
            $table->foreign('permission_group_id')->references('id')->on('permission_groups')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('permission_id')->references('id')->on('permissions')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_group_permissions', function (Blueprint $table) {
            $table->dropForeign('permission_group_permission_permission_group_id_foreign');
            $table->dropForeign('permission_group_permission_permission_id_foreign');
        });
    }
}
