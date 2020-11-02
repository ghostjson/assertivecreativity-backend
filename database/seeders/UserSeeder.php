<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];

        $u = new User;
        $u->first_name = 'admin';
        $u->last_name = 'acc';
        $u->email = 'admin@ac.com';
        $u->password = '17291234';
        $u->role_id = 1;
        $u->save();

        $u = new User;
        $u->first_name = 'vendor';
        $u->last_name = 'acc';
        $u->email = 'vendor@ac.com';
        $u->password = '17291234';
        $u->role_id = 2;
        $u->save();

        $u = new User;
        $u->first_name = 'user';
        $u->last_name = 'acc';
        $u->email = 'user@ac.com';
        $u->password = '17291234';
        $u->role_id = 2;
        $u->save();


        $this->generator($users);

        User::factory()->times(10)->create();

    }

    public function generator(array $users) : void
    {
        foreach ($users as $user)
        {
            User::createUser($user);
        }
    }
}
