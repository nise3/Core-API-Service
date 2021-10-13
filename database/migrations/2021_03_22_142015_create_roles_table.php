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
            $table->string('key', 100)->unique();
            $table->string('title_en', 191);
            $table->string('title', 300)->nullable();

            $table->unsignedMediumInteger('permission_group_id')->nullable();
            $table->unsignedMediumInteger('permission_sub_group_id')->nullable();

            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedInteger('organization_association_id')->nullable();
            $table->unsignedInteger('institute_id')->nullable();

            $table->text('description')->nullable();

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
