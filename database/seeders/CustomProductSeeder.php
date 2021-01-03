<?php

namespace Database\Seeders;

use App\Models\CustomProduct;
use Illuminate\Database\Seeder;

class CustomProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomProduct::factory()->times(10)->create();
    }
}
