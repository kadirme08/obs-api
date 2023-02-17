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
        Schema::table('subject_root', function (Blueprint $table) {
            $table->bigInteger('ogrenci_id')->after('ogretmen_id');
            $table->foreign('ogrenci_id')->references('id')->on('studentinfo');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subject_root', function (Blueprint $table) {
            //
        });
    }
};
