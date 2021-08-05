<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name');
            $table->string('uri', 300);
            $table->unsignedTinyInteger('method')->comment('1 => GET, 2 => POST, 3 => PUT, 4 => PATCH, 5 => DELETE');
            $table->unsignedTinyInteger('row_status')->default(1);
            $table->timestamps();

            $table->unique(['uri', 'method'], 'perm_uri_method_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
