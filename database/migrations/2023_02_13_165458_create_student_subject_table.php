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
        Schema::create('student_subject', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ogrenci_id');
            $table->bigInteger('sinif_id');
            $table->bigInteger('ders_secimi_id');
            $table->foreign('ogrenci_id')->references('id')->on('studentinfo')->onDelete('cascade');
            $table->foreign('sinif_id')->references('id')->on('classroom')->onDelete('cascade');
            $table->foreign('ders_secimi_id')->references('id')->on('subject_root')->onDelete('cascade');
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
        Schema::dropIfExists('student_subject');
    }
};
