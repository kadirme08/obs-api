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
            $table->string('ders_gunu');
            $table->string('ders_id');
            $table->string('ogretmen_id');
            $table->string('sinif_id');
            $table->string('ders_baslangic_saati');
            $table->string('ders_bitis_saati');
            $table->foreign('ders_id')->references('id')->on('subject')->onDelete('cascade');
            $table->foreign('ogretmen_id')->references('id')->on('teacher_info')->onDelete('cascade');
            $table->foreign('sinif_id')->references('id')->on('classroom')->onDelete('cascade');
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
