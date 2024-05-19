<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

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

    public function login(Request $request){

        $input = $request->all();
 
        $cekusername = User::where('username',$input['username'])->get();
        if (count($cekusername)>0) {
            if(auth()->attempt(array('username'=>$input['username'],'password'=>$input['password']))){
                return response()->json([
                    'status' => true,
                    'message' => 'Login berhasil!'
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Password salah!'
                ]);
            }
        }else{
            return response()->json([
                'status' => false,
                'message' => 'User belum terdaftar!'
            ]);
        }

    }
}
