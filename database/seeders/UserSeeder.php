<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Miguel De Jesus',
            'email' => 'mig@correo.com',
            'password' => bcrypt('12345678')
        ])->assignRole('admin');

        User::create([
            'name' => 'Pedro Camacho',
            'email' => 'pedro@correo.com',
            'password' => bcrypt('12345678')
        ])->assignRole('admin');
        
        User::create([
            'name' => 'Lucho',
            'email' => 'Lucho@correo.com',
            'password' => bcrypt('12345678')
        ])->assignRole('admin');


        User::create([
            'name' => 'Paquito',
            'email' => 'Paquito@correo.com',
            'password' => bcrypt('12345678')
        ])->assignRole('supervisor');

    }
}
