<?php

namespace Database\Seeders;

use App\Models\BiYAnalitica;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BiYAnaliticaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BiYAnalitica::factory()->count(10)->create();
    }
}
