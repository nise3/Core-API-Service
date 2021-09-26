<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedInteger('video_category_id')->nullable();
            $table->string('title_en', 191);
            $table->string('title_bn', 191);
            $table->text('description_en')->nullable();
            $table->text('description_bn')->nullable();
            $table->unsignedTinyInteger('video_type')->default(0)->comment('youtube => 1, uploaded => 2');
            $table->string('youtube_video_url', 255)->nullable();
            $table->string('youtube_video_id', 20)->nullable();
            $table->string('uploaded_video_path', 191)->nullable();
            $table->string("alt_title_en")->nullable();
            $table->string("alt_title_bn")->nullable();
            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();
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
        Schema::dropIfExists('videos');
    }
}
