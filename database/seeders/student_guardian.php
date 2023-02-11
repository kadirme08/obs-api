<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class student_guardian extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\student_guardian::create([
            'id'=>1,
            'user_id'=>'1',
            'tc_kimlik'=>"123456789",
            'isim_soyisim'=>"ogrenci velisi",
            'adres'=>'kayısdağı mahallesi/ataşehir/ist',
            'email'=>"veli@gmail.com",
            'telefon'=>"05379240842-7",
            'dogum_tarihi'=>"09.01.1946",
            'cinsiyet'=>"erkek",
            'profil_foto'=>"avatar.jpg",
        ]);
    }
}
