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
        Schema::create('classroom_subject', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sinif_id');
            $table->bigInteger('ders_id');
            $table->bigInteger('ogretmen_id');
            $table->foreign('sinif_id')->references('id')->on('classroom_status')->onDelete('cascade');
            $table->foreign('ders_id')->references('id')->on('subject')->onDelete('cascade');
            $table->foreign('ogretmen_id')->references('id')->on('teacherinfo')->onDelete('cascade');
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
        Schema::dropIfExists('classroom_subject');
    }
};
