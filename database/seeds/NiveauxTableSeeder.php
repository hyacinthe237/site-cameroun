<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;
class NiveauxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $niveaux = [
           ["name" => "Niveau 1", 'display_name' => 'Niveau 1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
           ["name" => "Niveau 2", 'display_name' => 'Niveau 2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
           ["name" => "Niveau 3", 'display_name' => 'Niveau 3', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
           ["name" => "Niveau 4", 'display_name' => 'Niveau 4', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
           ["name" => "Niveau 5", 'display_name' => 'Niveau 5', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
       ];

      DB::table('niveaux')->insert($niveaux);

    }
}
