<?php

use Illuminate\Database\Seeder;
use App\Models\Formation;
use Carbon\Carbon;


class FormationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Formation::create([
            'number'      => 1000000,
            'session_id'  => 1,
            'title'       => 'Formation 1',
            'start_date'  => '2020-07-15 08:00',
            'end_date'    => '2020-07-19 08:00',
            'places'      => 10,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
