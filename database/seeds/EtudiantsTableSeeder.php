<?php

use Illuminate\Database\Seeder;
use App\Models\Etudiant;
use App\Models\FormationEtudiant;
use Carbon\Carbon;

class EtudiantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $etudiant_01 = Etudiant::create([
            'number'          => 1000000,
            'niveau_id'       => 1,
            'firstname'       => 'Prenom Stagiaire 1',
            'lastname'        => 'Nom Stagiaire 1',
            'phone'           => '691636304',
            'email'           => 'stagiaire1@email.com',
            'sex'             => 'Male',
            'dob'             => '1991-06-24'
        ]);
    }
}
