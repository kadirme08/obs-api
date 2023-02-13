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
        Schema::create('subject_root', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sinif_id');
            $table->bigInteger('ders_id');
            $table->bigInteger('ogretmen_id');
            $table->foreign('sinif_id')->references('id')->on('classroom');
            $table->foreign('ders_id')->references('id')->on('subject');
            $table->foreign('ogretmen_id')->references('id')->on('teacherinfo');
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
        Schema::dropIfExists('subject_root');
    }
};
