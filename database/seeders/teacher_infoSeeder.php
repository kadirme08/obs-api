<?php

namespace Database\Seeders;

use App\Models\teacherinfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class teacher_infoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        teacherinfo::create([

            'id'=>1,
            'user_id'=>'2',
            'tc_kimlik'=>"123456789",
            'isim_soyisim'=>"Öğretmen",
            'adres'=>'kayısdağı mahallesi/ataşehir/ist',
            'email'=>"ogretmen@gmail.com",
            'telefon_no'=>"05379240847",

            'cinsiyet'=>"erkek",
            'profil_foto'=>"avatar.jpg",
        ]);
    }
}
