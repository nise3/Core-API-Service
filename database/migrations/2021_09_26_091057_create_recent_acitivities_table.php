<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecentAcitivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recent_acitivities', function (Blueprint $table) {
            $table->increments("id");
            $table->string("title_en",191);
            $table->string("title_bn",500);
            $table->string("description_en")->nullable();
            $table->string("description_bn")->nullable();
            $table->tinyInteger('content_type')->comment("1=>Image,2=>Video,3=>Youtube Source")->nullable();
            $table->string('content_path')->nullable();
            $table->string("content_properties")->nullable();
            $table->string("alt_title_en")->nullable();
            $table->string("alt_title_bn")->nullable();
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
        Schema::dropIfExists('recent_acitivities');
    }
}
