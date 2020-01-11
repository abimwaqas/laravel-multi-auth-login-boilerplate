<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm(){
        return view('admin.auth.login');
    }

    public function login(Request $request){
        
        $this->validate($request, [
            'email' =>'required|email',
            'password' => 'required|min:6'
        ]);
        //Attempt to login
        if(Auth::guard('admin')->attempt(['email' => $request->email , 'password'=>$request->password], $request->remember)){
            //if Successfull then redirect to intended location

            $admin = Auth::guard('admin');

            if($admin){

				return redirect()->intended(route('admin.dashboard'));
            }


            
            $id = $admin->id();
            
            session(['user_id' => $id]);

            return redirect()->intended(route('admin.dashboard'));
        }
        $errors = [$this->username() => trans('auth.failed')];
//        $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);
        return redirect()->back()->withInput($request->only('email','remember'))->withErrors($errors);

    }

    public function username()
    {
        return 'email';
    }


    public function logout(Request $request)
    {
        if(Auth::guard('admin')){
            Auth::guard('admin')->logout();

            $request->session()->invalidate();

            return redirect()->route('admin.login');
        }
        return redirect()->route('admin.login');

    }

    
}
