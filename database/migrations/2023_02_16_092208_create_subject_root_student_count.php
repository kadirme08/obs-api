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
        Schema::create('subject_root_student_count', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ders_id');
            $table->bigInteger('ogrenci_id');
            $table->foreign('ders_id')->references('id')->on('subject')->onDelete('cascade');
            $table->foreign('ogrenci_id')->references('id')->on('studentinfo');
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
        Schema::dropIfExists('subject_root_student_count');
    }
};
