<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class CustomerLoginController extends Controller
{
    public function showLoginForm(){
        return view('user.login');
    }

    public function login(Request $request){
        $data = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!$data->fails()){
            $user = User::where('email', $request->email)
            ->where('user_type', 'Customer')
            ->first();

            if($user){
                if(Hash::check($request->password, $user->password)){
                    Auth::login($user);
                    return redirect('home');
                }else{
                    return redirect()
                ->back()
                ->withInput()
                ->with('message', 'Incorrect Password');
                }
            }else{
                return redirect()
                ->back()
                ->withInput()
                ->with('message', 'Email doesn\'t Exist');
            }
        }else{
            return redirect()
            ->back()
            ->withInput()
            ->withErrors($data);
        };
    }

    public function checklogin(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user_data = array(
            'email' => $request->email,
            'password' => $request->password
        );

        if(Auth::attempt($user_data)){
            return redirect('loginsuccess');
        }else{
            return back();
        }
    }

    public function loginsuccess(){
        return view('loginsuccess');
    }

    public function logout(){
        Auth::logout();
        return redirect('login');
    }
}
