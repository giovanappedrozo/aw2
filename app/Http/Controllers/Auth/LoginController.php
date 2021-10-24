<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function username()
    {
        return 'prontuario';
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $user = User::where('prontuario', $input['prontuario'])->first();
        if(isset($user)){
            if (Hash::check($input['senha'], $user->senha)) {
                if ($user->is_admin == 1) {
                    return redirect()->route('admin.home');
                }else{
                    return redirect()->route('home');
                }
            }else{
                $request->session()->flash('flash_message', 'Prontuário ou senha incorreta');
                return redirect()->route('login');
            }
        }
    }
}
