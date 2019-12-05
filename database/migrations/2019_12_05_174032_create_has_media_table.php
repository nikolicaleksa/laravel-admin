<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHasMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('has_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('gallery_id', false, true)->nullable();
            $table->bigInteger('media_id', false, true)->nullable();
            $table->timestamps();

            $table->foreign('gallery_id')->references('id')->on('gallery')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('media_id')->references('id')->on('media')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('has_media');
    }
}
