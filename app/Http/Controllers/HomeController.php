<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\CustomerNetwork;
use Validator;
use Illuminate\Support\Facades\Hash;
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
        return view('home');
    }

    public function profile()
    {
        $user = User::findorfail(Auth::user()->id);
        
        return view('user.profile', compact('user'));
    }

    public function changePassword(Request $request, User $user)
    {
        $data = $request->all();

        $confirm_old_password = Hash::check($data['old_password'], $user->password);

        if(!$confirm_old_password){
            return back()->with($this->_response(false, "Old password is incorrect")); 
        }

        $rules = ['password' => 'required|min:4'];

        $validate = Validator::make($data, $rules, $this->error_messages);

        if($validate->fails()){
            return back()->withErrors($validate);
        }
        
        $data['password'] = Hash::make($data['password']);
        
        $update = $user->update($data);

        if(!$update){
            return back()->with($this->_response(false, "Error 500. Please call the administrator")); 
        }

        return redirect('profile/'.$user->id.'/edit')->with($this->_response(true, "Change password successfully."));
    }

    public function privileges(CustomerNetwork $cn)
    {
        $data = [];

        $data = User::where('id', Auth::user()->id)->with('code')->first();

        $networks = $cn->getUserNetworks(Auth::user()->id);

        foreach ($networks as $key => $value) {

            $networks[$key]->created_at_beautified = date('F d, Y H:i:s', strtotime($value->created_at));

            $name = explode(' ', $value->name);

            $last_name = str_split($name[ count($name)-1 ]);


            $replace_ln = null;
            foreach ($last_name as $k => $v) {
                $replace_ln .= "*";
            }

            $name[ count($name)-1 ] = $replace_ln;

            $name = implode(' ', $name);

            $networks[$key]->network_name = $name;

        }

        return view('privileges')
        ->with(compact('data','networks'));

    }

    public function pos()
    {
        return view('pos');
    }

    public function reports()
    {
        return view('reports');
    }

    public function networks()
    {
        return view('networks');
    }

    public function commissions()
    {
        return view('commissions');
    }

    public function payouts() 
    {
        return view('payouts');
    }
}
