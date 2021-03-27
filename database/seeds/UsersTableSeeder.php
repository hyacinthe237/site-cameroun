<?php

use Illuminate\Database\Seeder;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id'        => 1,
            'number'         => 1000000,
            'firstname'      => 'Din',
            'lastname'       => 'Admin',
            'phone'          => '694694694',
            'email'          => 'admin@email.com',
            'password'       => bcrypt('secret'),
            'sex'            => 'Male',
            'is_active'      => 1,
            'api_token' => str_random(100)
        ]);
    }
}
