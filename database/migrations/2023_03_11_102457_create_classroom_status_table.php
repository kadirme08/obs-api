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
        Schema::create('classroom_status', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sinif_id');
            $table->bigInteger('sube_id');
            $table->string('status')->default(1);
            $table->foreign('sinif_id')->references('id')->on('classroom')->onDelete('cascade');
            $table->foreign('sube_id')->references('id')->on('classroom_branch')->onDelete('cascade');
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
        Schema::dropIfExists('classroom_status');
    }
};
