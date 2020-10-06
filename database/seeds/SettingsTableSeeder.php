<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Session;

class SettingsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
      Session::create(['name' => '2020', 'status' => 'pending' ]);

      $categories = [
           ["name" => "Propre", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
           ["name" => "Partenariale", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
           ["name" => "Commande", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
       ];

      DB::table('categories')->insert($categories);
  }
}
