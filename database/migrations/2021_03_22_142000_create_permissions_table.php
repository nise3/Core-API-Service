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
            $table->string('title_en', 250);
            $table->string('title', 500);
            $table->string('module', 191);
            $table->string('key', 191)->unique();
            $table->string('uri', 250);
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
