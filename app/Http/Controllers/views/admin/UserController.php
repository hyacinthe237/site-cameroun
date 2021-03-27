<?php

namespace App\Http\Controllers\views\admin;

use Hash;
use Mail;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = null;
        if ( $request->has('role') && $request->role != '' ) {
            $role = Role::where('name', $request->role)->first();
        }

        $keywords = $request->keywords;
        $users = User::when($keywords, function($query) use ($keywords) {
            return $query->where('firstname', 'like', '%'.$keywords.'%')
            ->orWhere('lastname', 'like', '%'.$keywords.'%');
        })
        ->when($role, function($query) use ($role) {
            return $query->where('role_id', $role->id);
        })
        ->orderBy('id', 'desc')
        ->get();

        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }


    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $user = User::find($id);
        if ( !$user  ) {
            return redirect()->route('users.index');
        }

        $roles = Role::get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function create () {
        $roles = Role::get();

        return view('admin.users.create', compact('roles'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
             'email'  => 'required',
             'firstname'  => 'required'
         ]);


         if($validator->fails())
             return redirect()->back()->withErrors(['validator' => 'Email, first name & last name are required!']);


         $user = User::whereEmail($request->email)->first();
         if ($user) {
             return redirect()->back()->withInput($request->all())->withErrors(['user' => 'Utilisateur existant']);
         }

         $last = User::orderBy('id', 'desc')->first();
         if ($last) $number = $last->number + rand(1, 4);

         $user = User::create([
             'role_id'       => self::ROLE_MEMBER,
             'number'        => $number,
             'api_token'     => str_random(128),
             'password'      => bcrypt($request->password),
             'email'         => $request->email,
             'firstname'     => $request->firstname,
             'lastname'      => $request->lastname,
             'phone'         => $phone,
             'dob'           => Carbon::parse($request->dob),
             'gender'        => $request->gender,
             'photo'         => $request->photo,
             'status'        => $request->status,
         ]);

         return redirect()->back()->with('message', 'User successfully created');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
             'email'  => 'required',
             'firstname'  => 'required'
         ]);


         if($validator->fails())
             return redirect()->back()->withErrors(['validator' => 'Email, first name & last name are required!']);


         $user = User::find($id);
         if ( !$user ) {
             return redirect()->back()->withErrors(['user' => 'Unknown user!']);
         }

         $user->phone     = $request->has('phone') ? $request->phone : $user->phone;
         $user->email     = $request->has('email') ? $request->email : $user->email;
         $user->firstname = $request->has('firstname') ? $request->firstname : $user->firstname;
         $user->lastname  = $request->has('lastname') ? $request->lastname : $user->lastname;
         $user->role_id   = $request->has('role_id') ? $request->role_id : $user->role_id;
         $user->status    = $request->has('status') ? $request->status : $user->status;
         $user->photo     = $request->has('photo') ? $request->photo : $user->photo;
         $user->dob       = $request->has('dob') ? Carbon::parse($request->dob) : $user->dob;
         $user->gender    = $request->has('gender') ? $request->gender : $user->gender;
         $user->save();

         return redirect()->back()->with('message', 'User successfully updated');
    }

}
