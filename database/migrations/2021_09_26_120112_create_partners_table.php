<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->increments("id");
            $table->string('title_en',191);
            $table->string('title_bn',500);
            $table->string('image');
            $table->string('domain')->nullable();
            $table->string("alt_title_en",191);
            $table->string("alt_title_bn",191);
            $table->tinyInteger("created_by");
            $table->tinyInteger("updated_by");
            $table->tinyInteger("row_status")->default(1);
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
        Schema::dropIfExists('partners');
    }
}
