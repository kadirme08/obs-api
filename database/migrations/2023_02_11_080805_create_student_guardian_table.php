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
        Schema::create('student_guardian', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->integer('tc_kimlik')->unique();
            $table->string('isim_soyisim');
            $table->string('adres');
            $table->string('email');
            $table->string('telefon');
            $table->string('dogum_tarihi');
            $table->string('cinsiyet');
            $table->string('profil_foto');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('student_guardian');
    }
};
