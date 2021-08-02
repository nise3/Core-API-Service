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
            $table->unsignedMediumInteger('permission_group_id');
            $table->unsignedMediumInteger('permission_id');

            $table->foreign('permission_group_id')
                ->references('id')
                ->on('permission_groups')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_group_permissions');
    }
}
