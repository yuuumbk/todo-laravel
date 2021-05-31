<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
    public function index(Request $request)
    {
      // return view('home');
      // if(Auth::check()){
        return redirect()->route('tasks.index');
      // } else {
      //   return view('auth.login');
      // }
    }
}
