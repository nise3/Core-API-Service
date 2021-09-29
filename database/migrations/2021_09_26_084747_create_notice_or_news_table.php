<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticeOrNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notice_or_news', function (Blueprint $table) {
            $table->increments("id");
            $table->tinyInteger('type')->comment('1=>Notice,2=>News');
            $table->string('title_en', 191);
            $table->string('title_bn', 500);
            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_bn')->nullable();
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->string("image_alt_title_en")->nullable();
            $table->string("image_alt_title_bn")->nullable();
            $table->string("file_alt_title_en")->nullable();
            $table->string("file_alt_title_bn")->nullable();
            $table->tinyInteger('row_status')->default(1);
            $table->dateTime('publish_date')->nullable();
            $table->dateTime('archive_date')->nullable();
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
        Schema::dropIfExists('notice_or_news');
    }
}
