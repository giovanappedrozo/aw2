<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\User;

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
        $data['agenda'] = Agendamento::orderby('data')->get();
        $data['usuarios'] = User::get();

        return view('home')->with('data', $data);
    }

    public function adminHome(Request $request)
    {
        return view('adminHome');
    }
}
