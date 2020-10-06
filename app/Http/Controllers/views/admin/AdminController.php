<?php

namespace App\Http\Controllers\views\admin;

use Auth;
use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Formation;
use App\Models\Formateur;
use App\Models\Niveau;
use App\Models\Session;
use App\Repositories\AdminRepository as adminRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    private $adminRepo;

    // model args
    public function __construct(adminRepo $adminRepo)
    {
        $this->adminRepo = $adminRepo;
    }

    public function dashboard (Request $request)
    {
        $user    = User::find(Auth::id());
        $users   = User::whereIsActive(true)->get();
        $session = Session::whereStatus('pending')->first();
        $data    = self::takeInfos($this->adminRepo, $session);

        return view('admin.all.dashboard', compact(['data', 'users', 'user', 'requetes', 'session']));
    }

    /**
     * Download PDF Formation
     * @param  [type] $id [description]
     * @return [type]         [description]
     */
    public function download (adminRepo $adminRepo)
    {
        $session = Session::whereStatus('pending')->first();

        $data = self::takeInfos($adminRepo, $session);

        $pdf = PDF::loadView('pdfs.dashboard', $data);
        return $pdf->stream();
    }

    /**
     * Recup Formation Information pqr session
     * @param  [type] $id [description]
     * @return [type]         [description]
     */
    private static function takeInfos ($adminRepo, $session)
    {
        $etudiants     = Etudiant::get();
        $formateurs    = Formateur::get();
        $niveaux       = Niveau::get();
        $formations    = Formation::where('end_date', '>=', Carbon::now())->get();

        $data = [
            'formations' => $formations,
            'formateurs' => $formateurs,
            'etudiants' => $etudiants,
            'session' => $session,
            'niveaux' => $niveaux,
        ];

        return $data;
    }


}
