<?php

namespace App\Http\Controllers;

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
     * @return 
     */
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/landing'); // atau abort(403);
        }

        return view('home');
    }
}
