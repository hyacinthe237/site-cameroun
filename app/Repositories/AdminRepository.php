<?php

namespace App\Repositories;

use DB;

class AdminRepository
{
    public function getStagiaires ($sessionId) {
        $personnes = DB::table('etudiants as e')
                        ->join('formation_etudiants as fe', 'fe.etudiant_id', '=', 'e.id')
                        ->where('fe.session_id', '=', $sessionId)
                        ->where('e.deleted_at', '=', null)
                        ->get();

        $uniques = array();
            foreach($personnes as $personne) {
                $key = $personne->number;
                $uniques[$key] = $personne;
            }

        return  $uniques;
    }
}
