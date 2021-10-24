<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'data' => ['required', 'date', 'min:today'],
            'periodo' => ['required'],
            'espaco' => ['required'],
            'solicitante' => ['required'],
        ]);
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
            $same = Agendamento::where(array('periodo' => $request->input('periodo'), 'data' => $request->input('data'), 'espaco' => $request->input('espaco')));

            if(!isset($same)){
                Agendamento::create([
                    'periodo' => $request->input('periodo'),
                    'espaco' => $request->input('espaco'),
                    'solicitante' => Auth::user()->id,
                    'data' => $request->input('data'),
                ]);  
                
                return redirect('home');
            }
            else{
                $request->session()->flash('flash_message', 'Esse espaço já está reservado nesse horário. Escolha outra data ou período.');
                return redirect('agendar');
            }
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
