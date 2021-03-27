<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SettingsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
      $tables = [
           ["name" => "Table 1", 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
       ];

      DB::table('tables')->insert($tables);

      $billets = [
           [
             "table_id" => 1, "name" => "DIN EKOLO", "code" => str_random(8), "type" => "Couple", "civilite" => "M. & Mme",
             'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
           ],
       ];

      DB::table('billets')->insert($billets);
  }
}
