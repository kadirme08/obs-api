<?php

namespace Database\Seeders;

use App\Models\studentinfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class student_infoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        studentinfo::create([
           'id'=>1,
            'user_id'=>'1',
           'tc_kimlik'=>"123456789",
            'ogrenci_no'=>"123456789",
            'isim_soyisim'=>"Kadircan koçak",
            'adres'=>'kayısdağı mahallesi/ataşehir/ist',
            'email'=>"ogrenci@gmail.com",
            'telefon'=>"05379240847",
            'dogum_tarihi'=>"09.01.1999",
            'cinsiyet'=>"erkek",
            'profil_resim'=>"avatar.jpg",
        ]);



    }
}
