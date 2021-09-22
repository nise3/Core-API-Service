<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('institute_id')->index('static_assets_fk_institute_id');
            $table->string('title', 500);
            $table->string('sub_title', 500);
            $table->unsignedTinyInteger('is_button_available')->default(0);
            $table->string('button_text', 20)->nullable();
            $table->string('link', 191)->nullable();
            $table->string('slider', 191)->nullable();
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
        Schema::dropIfExists('sliders');
    }
}
