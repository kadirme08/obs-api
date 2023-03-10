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
        Schema::create('time_table', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('gun_id')->unsigned();
            $table->bigInteger('sinif_id')->unsigned();
            $table->bigInteger('ders_id')->unsigned();
            $table->bigInteger('ogretmen_id')->unsigned();
            $table->foreign('gun_id')->references('id')->on('days')->onDelete('cascade');
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
        Schema::dropIfExists('time_table');
    }
};
