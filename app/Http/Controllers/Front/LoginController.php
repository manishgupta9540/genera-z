<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function register()
    {
        return view('front.auth.register');
    }

    public function studentRegister(Request $request)
    {

        $rules= [
            'first_name'    => 'required|regex:/^[a-zA-Z]+$/u|min:1|max:255',
            'last_name'     => 'required|regex:/^[a-zA-Z]+$/u|min:1|max:255',
            'email'         => 'required|unique:users,email',
            'password'      => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json([
                'success'   => false,
                'msg'       => 'Error Occurred',
                'errors'    => $validator->errors(),
                'error'     =>'validation',
            ]);
        }

        DB::beginTransaction();
        try{

            $user_data =
                [
                    'name'          => $request->first_name,
                    'last_name'     => $request->last_name,
                    'email'         => $request->email,
                    'user_type'     => 3,
                    'is_completed'  => '1',
                    'status'        => '1',
                    'password'      => Hash::make($request->input('password')),
                    'created_at'    => date('Y-m-d H:i:s')

                ];
                    // dd($user_data);
            $user = DB::table('users')->insertGetId($user_data);

            //mail send user registered
            $name = $request->first_name;
            $email = $request->email;

            $id  =  urlencode(base64_encode($user));

            $url = url('/student-login-from/' . $id . '?courseId=' . $request->course_id);
            $data  = array('name'=>$name,'link'=>$url,'email'=>$email);

            Mail::send('mails.students_registered', ['email' => $email,'link'=>$url,'name' => $name ,'courseId' => $request->course_id], function ($messages) use ($email, $name) {
                $messages->to($email, $name)
                ->from($email.env('MAIL_USERNAME'), 'Generation-Z');
                $messages->subject("Registration Successful!");
            });

            DB::commit();

            return response()->json([
                'success'   =>  true,
                'msg'       =>  'Registration Successful',
                'custom'    =>  'yes',
                'form_type'  => 'register',
                'email'     =>  $request->email,
                'errors'    => []
              ]);
        }
        catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }

    public function studentVerify()
    {
        return view('front.auth.student-verify');
    }

    public function studentLoginFrom(Request $request)
    {
        $id = base64_decode($request->id);

        $Cid = $request->courseId;
        $users = User::where('id',$id)->update(['is_verified'=>1]);
        if ($Cid) {
            return redirect()->route('courseDetail',['id'=>$Cid,'userId'=>$id])->with('enrolModal', true);
        }
        return redirect()->route('home')->with('loginModal', true);
    }


    public function login()
    {
        return view('front.auth.login');
    }

    public function userLogin(Request $request)
    {
        // dd($request->all());
        $rules= [
            'user_email'         => 'required',
            'user_password'      => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'error' =>'validation',
                'errors' => $validator->errors()
            ]);
        }
        $user = User::where('email',$request->user_email)->first();

        if(isset($user))
        {

            if($user->status == 1)
            {
                $credentials = [
                    'email' => $request->user_email,
                    'password' => $request->input('user_password')
                ];
                if($user->user_type == 3 && $user->is_verified == 1)
                {

                    if (Auth::attempt($credentials))
                    {
                        if($user->is_subcription == '0')
                        {
                            return response()->json([
                                'success' => true,
                                'custom'  => 'yes',
                                'msg'     => 'Logged in Successfully',
                                'refresh' => true,
                                'errors'  => [],
                                'type'    => 'success' // Add type here
                            ]);

                        }
                        return response()->json([
                            'success' => true,
                            'custom'  => 'yes',
                            'msg'     => 'Logged in Successfully',
                            'refresh' => true,
                            'errors'  => [],
                            'type'    => 'success' // Add type here
                        ]);
                    }
                    else
                    {
                        return response()->json([
                            'success'    =>false,
                            'msg'        =>'wrong_email_or_password',
                            'custom'     =>'yes',
                            'errors'     =>[],
                            'error'      =>'validation',
                        ]);
                    }
                }
                else
                {
                    $msg = $user->is_verified == 0 && $user->status == 1 ? 'Email not verified, Please verify and then login.' : 'Wrong email or password. Please verify your email first.';
                    $email = ($user->is_verified == 0 && $user->status == 1) ? $request->user_email : '';
                    return response()->json([
                        'success'    =>false,
                        'msg' => $msg ,
                        'custom'  =>'yes',
                        'email'  =>$email,
                        'errors'  =>[],
                        //'error'      =>'validation',
                    ]);
                }
            }
            else{
                return response()->json([
                    'success'    => false,
                    'msg'        => 'Your account deactivated please contact admin!',
                    'custom'     => 'yes',
                    'email'      =>  '',
                    'errors'     => [],
                    'error'      =>'validation',
                ]);
            }

        }
        else
        {
            return response()->json([
                'success'    =>false,
                'msg'        =>'wrong_email_or_password',
                'custom'     =>'yes',
                'errors'     =>[],
                'error'      =>'validation',
            ]);
        }
    }

    public function studentDetailsForm()
    {
        $users = User::where('id',Auth::user()->id)->first();
        $states = DB::table('states')->get();
        $countries = DB::table('countries')->get();
        return view('front.auth.student-login-from',compact('users','states','countries'));
    }

    public function resendMail(Request $request){
        try {
            $users = User::where('email',$request->email)->first();
            if(!empty($users)){
                $id  =  urlencode(base64_encode($users->id));
                $name = $users->name .' '. $users->last_name;
                $email = $users->email;
                $url = url('/student-login-from/' . $id);
                $data  = array('name'=>$name,'link'=>$url,'email'=>$email);
                Mail::send('mails.students_registered', ['email' => $email,'link'=>$url,'name' => $name ], function ($messages) use ($email, $name) {
                    $messages->to($email, $name)
                    ->from($email.env('MAIL_USERNAME'), 'Generation-Z');
                    $messages->subject("Registration Successful!");
                });
                return response()->json(['success'=>true,'msg'=>'Mail has been send please check your mail']);
            }else{
                return response()->json(['success'=>false,'msg'=>'Mail not send']);
            }
        } catch (\Throwable $th) {
            return response()->json(['success'=>false,'msg'=>$th->getMessage()]);
        }
    }
    public function logout(Request $request)
    {
        $auth = Auth::user();
        $route = 'admin.login';
        if(!empty($auth)){
            if ($auth->user_type == 3) {
                $route = 'home';
            }
        }else{
            $route = 'home';
            return redirect()->route($route)->with('msg', 'Logged out successfully.');;
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($route)->with('msg', 'Logged out successfully.');;
    }
}
