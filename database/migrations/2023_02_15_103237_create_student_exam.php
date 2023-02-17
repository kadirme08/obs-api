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
        Schema::create('student_exam', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('exam_id');
            $table->bigInteger('ders_id');
            $table->bigInteger('sinif_id');
            $table->string('baslangic_tarihi');
            $table->string('bitis_tarihi');
            $table->foreign('exam_id')->references('id')->on('exam_name')->onDelete('cascade');
            $table->foreign('ders_id')->references('id')->on('subject')->onDelete('cascade');
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
        Schema::dropIfExists('student_exam');
    }
};
