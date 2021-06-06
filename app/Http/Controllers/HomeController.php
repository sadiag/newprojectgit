<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\User;
Use DB;
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
        // $users = User::all();

        $users = DB::table('users')->get();
        return view('home',compact('users'));
    }
}
