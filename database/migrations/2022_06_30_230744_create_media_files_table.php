<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_files', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('artist');
            $table->string('title');
            $table->string('feat')->nullable();
            $table->string('original_name')->nullable();
            $table->string('genre')->nullable();
            $table->text('track_path');
            $table->text('track_image')->nullable();
            $table->string('launched_date')->nullable();
            $table->enum('for_download', ['1','0'])->default(0);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_files');
    }
}
