<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use App\User;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $name = Auth::user();
        return view('home',compact('name'));
    }

    public function volunteers()
    {
        $users = DB::table('users')
            ->select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')->get();
        return $users;

    }

    public function updateProfile(Request $request){
    
        $user = auth('api')->user();
        $this->validate($request,[
            'name' => 'required | string | max:55',
            'age' => 'required | integer | max:100 | min:18',
            'address' => 'required | string | max:255',
            'gender' => 'required | string',
            'health_condition' => 'required | string | max:255',
            'email' => 'required | string | email | max:255 | unique:users,email,'.$user->id,
            'password' => 'nullable | string | min:8 | confirmed',
        ]);

       if( $request->password){
            $update = $user->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'age' => $request['age'],
                'gender' => $request['gender'],
                'address' => $request['address'],
                'health_condition' => $request['health_condition'],
                'password' => Hash::make($request['password']),
            ]);
       }else{
        $update = $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'age' => $request['age'],
            'gender' => $request['gender'],
            'address' => $request['address'],
            'health_condition' => $request['health_condition']
        ]);
       }

        return response()->json([
            'status' => $update
        ]) ;
    }

    // $2y$10$UbPK3SjI7sLXA/DitNseSunt7Zx2gMrbRG34AevRZQqbxnbl2ppdu
    //$2y$10$IvwL9AZ11S.u5vMxWXN1oOTk1BZwCl/IcYfCoRuSxYFJnSiJCy8kO
    // $2y$10$IvwL9AZ11S.u5vMxWXN1oOTk1BZwCl/IcYfCoRuSxYFJnSiJCy8kO
    // $2y$10$Ikxt2nSRuQm0YUhB8OA6fuuWJAH/80W6be16IADvzH89ykHIGGn.G


}
