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
        Schema::table('studentinfo', function (Blueprint $table) {
            $table->bigInteger('sinif_id')->after('user_id')->unsigned();
            $table->bigInteger('sube_id')->after('user_id')->unsigned();
            $table->foreign('sinif_id')->references('id')->on('classroom')->onDelete('cascade');
            $table->foreign('sube_id')->references('id')->on('classroom_branch')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('studentinfo', function (Blueprint $table) {
            //
        });
    }
};
