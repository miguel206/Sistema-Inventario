<?php

namespace Database\Seeders;

use App\Models\Bien;
use App\Models\Personal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Personal::factory()->count(10)->create();
    }
}
