<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Role::create([
          'name'=>'ogrenci',
           'guard_name'=>'api'
       ]);
       Role::create([
           'name'=>'ogretmen',
           'guard_name'=>'api'

       ]);
        Role::create([
            'name'=>'admin',
            'guard_name'=>'api'

        ]);
    }
}
