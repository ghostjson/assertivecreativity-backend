<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'vendor', 'user'];

        $this->generator($roles);
    }

    public function generator(array $roles)
    {
        foreach ($roles as $role)
        {
            $roleInstance = new Role;
            $roleInstance->name = $role;
            $roleInstance->save();
        }
    }
}
