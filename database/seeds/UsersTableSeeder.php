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
            'role_id'    => 1,
            'number'     => 1000000,
            'firstname'  => 'Hyacinthe',
            'lastname'   => 'ABANDA',
            'phone'      => '651780612',
            'email'      => 'hyacinthabanda@gmail.com',
            'password'   => bcrypt('pass'),
            'gender'     => 'Male',
            'status'     => 'active',
            'dob'        => '1991-06-24',
            'api_token'  => str_random(128)
        ]);

    }
}
