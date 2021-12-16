<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\UpdateNotification;
use Illuminate\Support\Facades\Notification;

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
        $notifications = auth()->user()->unreadNotifications;

        return view('agendar', compact('notifications'))->with('data', $data);
    }
    
    public function periodos(){
        return $periodos = ['M1', 'M2', 'M3', 'M4', 'M5', 'M6', 'V0', 'V1', 'V2', 'V3', 'V4', 'V5', 'V6', 'N0', 'N1', 'N2', 'N3', 'N4', 'N5', 'N6'];
    }

    public function espacos(){
        return $espacos = ['Laboratório', 'Anfiteatro', 'Sala de aula'];
    }

    public function store(Request $request)
    {      
        $espacos = self::espacos();
        $periodos = self::periodos();

        if(Auth::user()->is_admin == 0){
            $same = Agendamento::where(array('periodo' => $periodos[$request->input('periodo')-1], 'data' => $request->input('data'), 'espaco' => $espacos[$request->input('espaco')-1]))->first();

            if(!$same){
                Agendamento::create([
                    'periodo' => $request->input('periodo'),
                    'espaco' => $request->input('espaco'),
                    'solicitante' => Auth::user()->id,
                    'data' => $request->input('data'),
                ]); 
                
                return redirect('email');
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
        $notifications = auth()->user()->unreadNotifications;

        return view('agendamento', compact('notifications'))->with('data', $data);
    }

    public function update(Request $request)
    {        
        if(Auth::user()->is_admin == 1){
            $agendamento = Agendamento::where('id', $request->input('id'));
            $agendamento->update([
                'periodo' => $request->input('periodo'),
                'espaco' => $request->input('espaco'),
                'data' => $request->input('data'),
            ]);  
            $agendamento = $agendamento->first();

            $user = User::where('id', $agendamento->solicitante)->first();

            Notification::send($user, new UpdateNotification($agendamento));

            return redirect('admin/home');
        }
    }

    public function destroy($id)
    {
        $agendamento = Agendamento::find($id);
        $agendamento->delete();
        
        return redirect('agenda');
    }
}
