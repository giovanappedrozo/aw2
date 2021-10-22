<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    public function index()
    {
        $data['agenda'] = Agendamento::orderby('data')->get();
        $data['usuarios'] = User::get();

        return view('agenda')->with('data', $data);
    }

    public function create()
    {
        $data['date'] = date('Y-m-d');
        $data['periodos'] = self::periodos();
        $data['espacos'] = self::espacos();
        return view('agendar')->with('data', $data);
    }
    
    public function periodos(){
        return $periodos = ['M1', 'M2', 'M3', 'M4', 'M5', 'M6', 'V0', 'V1', 'V2', 'V3', 'V4', 'V5', 'V6', 'N0', 'N1', 'N2', 'N3', 'N4', 'N5', 'N6'];
    }

    public function espacos(){
        return $espacos = ['Laboratório', 'Anfiteatro', 'Sala de aula'];
    }

    public function store(Request $request)
    {      
        if(Auth::user()->is_admin == 0){
            Agendamento::create([
                'periodo' => $request->input('periodo'),
                'espaco' => $request->input('espaco'),
                'solicitante' => Auth::user()->id,
                'data' => $request->input('data'),
            ]);  
            
            $request->session()->flash('success', 'The event was successfully saved!');
            return redirect('home');
        }
    }

    public function show($id)
    {
        $data['date'] = date('Y-m-d');
        $data['agendamento'] = Agendamento::where('id', $id)->first();
        $data['periodos'] = self::periodos();
        $data['espacos'] = self::espacos();
        return view('agendamento')->with('data', $data);
    }

    public function update(Request $request)
    {        
        if(Auth::user()->is_admin == 1){
            Agendamento::where('id', $request->input('id'))->update([
                'periodo' => $request->input('periodo'),
                'espaco' => $request->input('espaco'),
                'solicitante' => $request->input('solicitante'),
                'data' => $request->input('data'),
            ]);  

            return redirect('agenda');
        }
    }

    public function destroy($id)
    {
        $agendamento = Agendamento::find($id);
        $agendamento->delete();
        
        return redirect('agenda');
    }
}
