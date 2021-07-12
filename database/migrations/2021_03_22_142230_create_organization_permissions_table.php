<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_permissions', function (Blueprint $table) {
            $table->unsignedInteger('organization_id')->unsigned();
            $table->unsignedInteger('permission_id')->unsigned();

            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organization_permissions', function (Blueprint $table) {
            $table->dropForeign('organization_permission_organization_id_foreign');
            $table->dropForeign('organization_permission_permission_id_foreign');
        });
    }
}
