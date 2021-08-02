<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('title_en', 191)->nullable();
            $table->string('title_bn', 300)->nullable();

            $table->unsignedMediumInteger('permission_group_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedInteger('institute_id')->nullable();

            $table->text('description')->nullable();
            $table->string('key', 191)->unique();

            $table->unsignedTinyInteger('row_status')->default(1);
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
        Schema::dropIfExists('roles');
    }
}
