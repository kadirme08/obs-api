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
        Schema::table('student_payment', function (Blueprint $table) {
            $table->string('odeme_yili')->after('user_id');
            $table->string('aciklama')->after('odenmis_tutar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_payment', function (Blueprint $table) {
            //
        });
    }
};
