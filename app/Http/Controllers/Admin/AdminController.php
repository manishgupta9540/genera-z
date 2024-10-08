<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function adminLogin()
    {
        return view('admin.auth.login');
    }

    public function dashboard()
    {
        return view('admin.index');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->passes())
        {
            $user_role = User::where('email',$request->email)->first();
                if($user_role->status == 1 ){
                    $credentials = $request->only('email', 'password');

                if (Auth::attempt($credentials)) {
                    if (Auth::user()->user_type == 0) {
                        return redirect()->route('admin.dashboard');
                    }else{
                        return redirect()->route("admin.login")->with('error','Error Email/Password or wrong');
                    }
                }
                else
                {
                    return redirect()->route("admin.login")->with('error','Error Email/Password or wrong');
                }
            }else{
                return redirect()->route("admin.login")->with('error','User Not Active Please Connect Admin');
            }


        }else{
            return redirect()->route('admin.login')->withErrors($validator)->withInput($request->only('email'));
        }
    }
}
