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
        Schema::table('classroom_head_of_departman', function (Blueprint $table) {
          $table->bigInteger('sube_id')->after('sinif_id');
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
        Schema::table('classroom_head_of_departman', function (Blueprint $table) {
            //
        });
    }
};
