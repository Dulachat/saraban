<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Validated;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'username' => 'required|max:50',
            'password' => 'required'
        ]);
        if (auth()->attempt(array('username' => $input['username'], 'password' => $input['password']))) {
            if (auth()->user()->u_level_id == 1) { //แอดมิน
                return redirect()->route('home');

            } if(auth()->user()->u_level_id == 2) { //อาจารย์
                return redirect()->route('homeUser'); 
            }
            if(auth()->user()->u_level_id == 3) { //จนท.คณะ
                return redirect()->route('home');
            }
            if(auth()->user()->u_level_id == 4) { //จนท.ภาควิชา
                return redirect()->route('homestaff.ajax');
            }
            if(auth()->user()->u_level_id == 5) { //ผู้บริหาร
                return redirect()->route('homeUser');
            }
            if(auth()->user()->u_level_id == 6) { //คณบดี
                return redirect()->route('homeDean');
            }
        }else{
            return Redirect::back()->withErrors(['error' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง']);
        }
    }
}
