<?php

namespace Database\Seeders;

use App\Models\Bien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BienesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Bien::factory()->count(1000)->create();
    }
}
