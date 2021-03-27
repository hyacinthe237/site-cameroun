<?php

namespace App\Http\Controllers\views\admin;

use Auth;
use DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function home()
    {
        $user = User::with('role')->where('id', Auth::id())->first();

        return view('admin.all.dashboard', compact('user'));
    }

    public function files()
    {
        return view('admin.all.files');
    }

}
