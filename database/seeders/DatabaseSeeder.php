<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CustomProduct;
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
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            CustomProductSeeder::class,
            TagSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
