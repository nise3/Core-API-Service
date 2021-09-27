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
            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->string('title_en', 191);
            $table->string('title_bn', 500);
            $table->string('sub_title_en', 191);
            $table->string('sub_title_bn', 500);
            $table->unsignedTinyInteger('is_button_available')->default(0);
            $table->string('button_text', 20)->nullable();
            $table->string('link', 191)->nullable();
            $table->text('slider_images')->comment("[image_link1,image_link2.........]");
            $table->string('alt_title_en')->nullable();
            $table->string('alt_title_bn')->nullable();
            $table->unsignedTinyInteger('row_status')->default(1);
            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();
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
