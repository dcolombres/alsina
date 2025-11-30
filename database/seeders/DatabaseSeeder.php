<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
         public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'), // password
        ]);
        $user->assignRole('admin');

        $this->call([
            ClienteSeeder::class,
            StaffSeeder::class,
            ProyectoSeeder::class,
            BiYAnaliticaSeeder::class,
        ]);
    }}
