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
        Schema::create('classroom', function (Blueprint $table) {
            $table->id();
            $table->string('sinif_adi');
            $table->string('sinif_sayisi');
            $table->string('sinif_durum')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *W
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classroom');
    }
};
