<?php

namespace App\Http\Controllers\views\admin;

use Auth;
use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Billet;
use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    public function dashboard (Request $request)
    {
        $user    = User::find(Auth::id());
        $billets = Billet::get();
        $tables  = Table::get();

        $code = $request->keywords;
        $billet = Billet::with('table')->whereCode($code)->first();

        // if (!$billet) {
        //   return redirect()->back()->with('message', 'Le code est érroné');
        // }

        return view('admin.all.dashboard', compact(['billets', 'billet', 'user', 'tables']));
    }

}
