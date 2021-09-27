<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('gallery_category_id');
            $table->unsignedTinyInteger('content_type')->comment('1 => Image, 2 => Video');
            $table->string('content_title', 500)->nullable();
            $table->string('content_path', 191);
            $table->string('content_properties', 191)->nullable();
            $table->string('alt_title_en')->nullable();
            $table->string('alt_title_bn')->nullable();
            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedTinyInteger('is_youtube_video')->default(0);
            $table->timestamp('publish_date')->nullable();
            $table->timestamp('archive_date')->nullable();
            $table->string('you_tube_video_id', 191)->nullable();
            $table->unsignedTinyInteger('row_status')->default(1);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('galleries');
    }
}
