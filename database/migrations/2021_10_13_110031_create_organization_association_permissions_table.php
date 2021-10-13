<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationAssociationPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_association_permissions', function (Blueprint $table) {
            $table->unsignedInteger('organization_association_id');
            $table->unsignedMediumInteger('permission_id');

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
        Schema::dropIfExists('organization_association_permissions');
    }
}
