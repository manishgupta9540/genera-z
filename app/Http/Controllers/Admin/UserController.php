<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\RoleMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role_as','0')->whereIn('status',['0','1'])->select('id','name','last_name','email','phone_number','role_id','created_at','status')->latest()->get();

            return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($row){

                if($row->status==1)
                {
                    $action_1 = '<span data-d="'.base64_encode($row->id).'"><a href="javascript:;" class="btn btn-outline-dark status" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('disable').'" title="Deactivate"><i class="far fa-times-circle"></i> Deactivate</a></span>
                                <span data-a="'.base64_encode($row->id).'" class="d-none"><a href="javascript:;" class="btn btn-outline-success status" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('enable').'" title="Active"><i class="far fa-check-circle"></i> Activate</a></span>';
                }
                else
                {
                    $action_1 = '<span class="d-none" data-d="'.base64_encode($row->id).'"><a href="javascript:;" class="btn btn-outline-dark status" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('disable').'" title="Deactivate"><i class="far fa-times-circle"></i> Deactivate</a></span>
                                <span data-a="'.base64_encode($row->id).'"><a href="javascript:;" class="btn btn-outline-success status" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('enable').'" title="Active"><i class="far fa-check-circle"></i> Activate</a></span>';
                }
                $edit_url = url('/user/role/edit',['id'=>base64_encode($row->id)]);

                $action_2 = '<a href="'.$edit_url.'" class="btn btn-outline-info" title="Edit"><i class="fas fa-edit text-info"></i></a>';

                $action_3 = '<span><a class="btn btn-outline-danger btn-rounded flush-soft-hover deleteBtn" data-bs-toggle="tooltip" data-placement="top" title=""
                            data-bs-original-title="Delete" href="javascript:void(0)" data-id="'.base64_encode($row->id).'">
                            <i class="fas fa-trash text-danger"></i>
                            </a></span>';


                $action =   '<div class="d-flex align-items-center">
                                <div class="d-flex">
                                '.$action_1.'
                                '.$action_2.'
                                '.$action_3.'
                                </div>
                            </div>';
                return $action;
                })
                ->editColumn('created_at', function ($user) {
                    $createdAt = $user->created_at;
                    if (is_string($createdAt)) {
                        $createdAt = Carbon::parse($createdAt);
                    }
                    return [
                        'display' => e($createdAt->format('m-d-Y')),
                        'timestamp' => $createdAt->timestamp
                    ];
                })
                ->addColumn('status', function ($data) {
                    if ($data->status==0){
                        return'<span data-dc="'.base64_encode($data->id).'" class="badge badge-danger">Inactive</span>
                        <span data-ac="'.base64_encode($data->id).'" class="badge badge-success d-none">Active</span>';
                    }
                    else{
                        return '<span data-dc="'.base64_encode($data->id).'" class="badge badge-danger d-none">Inactive</span>
                        <span data-ac="'.base64_encode($data->id).'" class="badge badge-success">Active</span>';
                    }
                })

                ->editColumn('role_id', function ($row) {
                    $Users = DB::table('roles')->where('id', $row->role_id)->first();
                    return ($Users!=null)?$Users->role:'';
                })
                ->addColumn('username', function ($row) {
                    $username = $row->name . ' ' . $row->last_name;
                    $modalTrigger = 'data-toggle="modal" data-target="#userModal" data-id="'.base64_encode($row->id).'"';
                    return '<a href="javascript:;" class="user-name-link no-underline" ' . $modalTrigger . '>' . e($username) . '</a>';
                })

                ->rawColumns(['action','role_id','status','username'])
                ->make(true);
        }

        return view('admin.users.index');
    }

    public function userCreate(Request $request)
    {

        if($request->isMethod('get'))
        {
            $roles = RoleMaster::whereIn('status',['1'])->select('id','role','status')->get();
            return view('admin.users.create',compact('roles'));
        }

        $rules = [
            'name'      => 'required|regex:/^[a-zA-Z ]+$/u|min:1|max:255',
            'email'     => 'required|email|unique:users',
            'contact_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'role_id'   => 'required',
            'password'  => 'required|min:8'

        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);

        }

        DB::beginTransaction();
        try{
            //dd($request->all());
            $new_role = new User();
            $new_role->name = $request->name;
            $new_role->email = $request->email;
            $new_role->phone_number = $request->contact_number;
            $new_role->role_id = $request->role_id;
            $new_role->password= Hash::make($request->input('password'));
            $new_role->status ='1';
            $new_role->role_as = '0';
            $new_role->created_at = date('Y-m-d H:i:s');
            $new_role->save();


            DB::commit();
            return response()->json([
                'success' => true
            ]);
        }
        catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }

    public function userRoleEdit(Request $request)
    {
        $role_id = base64_decode($request->id);

        $role_master = DB::table('roles')->where('active',true)->get();

        $rolesadmin = DB::table("users")->where('id', $role_id)->first();
        // dd($rolesadmin);
        return view('admin.users.edit',compact('rolesadmin','role_master'));
    }

    public function userRoleUpdate(Request $request)
    {
        $role_id = base64_decode($request->id);

        $this->validate($request,[
            'name' => 'required|regex:/^[a-zA-Z ]+$/u|min:1|max:255',
            'email' => 'required|email',
            'contact_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            //'role_id' => 'required',

        ]);

        // $validation = Validator::make($request->all(), $rules);

        // if ($validation->fails()) {

        //     return response()->json([
        //         'success' => false,
        //         'errors' => $validation->errors()
        //     ]);

        // }
        DB::beginTransaction();
        try{

            $data1 =   DB::table('users')->where('id',$role_id)->first();
            $status = $data1->status;

            $data = [
                'name'          => $request->input('name'),
                'email'         => $request->input('email'),
                'phone_number'  => $request->input('contact_number'),
                'role_id'       => $request->input('role_id'),
                'status'        => $status,
                'updated_at'    => date('Y-m-d H:i:s')
            ];

            DB::table('users')->where('id',$role_id)->update($data);

            DB::commit();
            return response()->json([
                'success' => true,
                'msg'     => "Save Successfully",
                'url' => route('user-roles.index')
            ]);
        }
        catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }

    }

    public function userRoleDelete(Request $request)
    {

        $role_id =base64_decode($request->id);
        $user = User::find($role_id);
        if($user){
            $user->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'User not found']);
    }




    public function userRolesStatus(Request $request)
    {
        $role_id=base64_decode($request->id);
        //$user = RoleMaster::find($role_id);
        $type = base64_decode($request->type);

        if($type == 'disable')
        {
            $user = User::find($role_id);
            $user->status = '0';
            $user->save();

            return response()->json([
                'success'=>true,
                'type' => $type,
                'message'=>'Status change successfully.'
            ]);
        }
        elseif($type == 'enable')
        {
            $user = User::find($role_id);
            $user->status = '1';
            $user->save();

            return response()->json([
                'success'=>true,
                'type' => $type,
                'message'=>'Status change successfully.'
            ]);
        }

    }


    public function details($id)
    {
        $userId = base64_decode($id);
        $user = User::find($userId);

        if ($user) {
            return view('admin.users.details', compact('user')); // Return a partial view with user details
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

}
