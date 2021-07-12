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
            $table->unsignedInteger('institute_id')->unsigned();
            $table->unsignedInteger('permission_id')->unsigned();

            $table->foreign('institute_id')->references('id')->on('institutes')->onDelete('cascade');
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
        Schema::table('institute_permissions', function (Blueprint $table) {
            $table->dropForeign('institute_permission_institute_id_foreign');
            $table->dropForeign('institute_permission_permission_id_foreign');
        });
    }
}
