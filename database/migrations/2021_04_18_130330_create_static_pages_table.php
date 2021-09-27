<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_pages_and_block', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->comment("1=>Block, 2=>Static Page");
            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->string('page_id', 191);
            $table->string('title_en', 191);
            $table->string('title_bn', 500);
            $table->text("description_en")->nullable();
            $table->text("description_bn")->nullable();
            $table->text('page_contents')->nullable();
            $table->tinyInteger('content_type')->comment("1=>Image,2=>Video,3=>Youtube");
            $table->string('content_path');
            $table->string('content_properties')->nullable();
            $table->string('alt_title_en')->nullable();
            $table->string('alt_title_bn')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->tinyInteger('row_status')->default(1);
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
        Schema::dropIfExists('static_pages');
    }
}
