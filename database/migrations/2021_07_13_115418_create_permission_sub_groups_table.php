<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionSubGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_sub_groups', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedMediumInteger('permission_group_id');
            $table->string('title_en');
            $table->string('title_bn', 300);
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
        Schema::dropIfExists('permission_sub_groups');
    }
}
