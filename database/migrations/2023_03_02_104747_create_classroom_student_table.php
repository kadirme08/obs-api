<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_student', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sinif_id')->unsigned();
            $table->bigInteger('ogrenci_id')->unsigned();
            $table->foreign('ogrenci_id')->references('id')->on('studentinfo')->onDelete('cascade');
            $table->foreign('sinif_id')->references('id')->on('classroom_status')->onDelete('cascade');
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
        Schema::dropIfExists('classroom_student');
    }
};
