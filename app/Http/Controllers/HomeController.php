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
        $notifications = auth()->user()->unreadNotifications;

        return view('home', compact('notifications'))->with('data', $data);
    }

    public function adminHome(Request $request)
    {
        $data['agenda'] = Agendamento::orderby('data')->get();
        $data['usuarios'] = User::get();
        $data['sala'] = 0;
        $data['lab'] = 0;
        $data['anfi'] = 0;
        $data['mat'] = 0;
        $data['ves'] = 0;
        $data['not'] = 0;

        for($i = 0; $i < sizeof($data['agenda']); $i++){
            $espaco = $data['agenda'][$i]['espaco'];
            $periodo = $data['agenda'][$i]['periodo'];

            switch($espaco){
                case 'Sala de aula': $data['sala']++; break;
                case 'Laboratório': $data['lab']++; break;
                case 'Anfiteatro': $data['anfi']++; break;
            }

            $periodo = $data['agenda'][$i]['periodo'];
            $periodo = str_split($periodo);
    
            switch($periodo[0]){
                case 'M': $data['mat']++; break;
                case 'V': $data['ves']++; break;
                case 'N': $data['not']++; break;
            }
        }

        return view('adminHome')->with('data', $data);
    }
}
