<?php

namespace Database\Seeders;

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
        \App\Models\User::factory(1)->create([
            'email' => 'junimhs10@gmail.com',
            'name' => 'Luis Henrique',
            'password' => bcrypt('junior')
        ]);

        \App\Models\User::factory(19)->create();
    }
}
