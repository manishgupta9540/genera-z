<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Hash;
use App\Helpers\Helper;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $status = $row->active ? 'Deactivate' : 'Activate';
                    $statusClass = $row->active ? 'dark' : 'success';
                    $statusIcon = $row->active ? 'times-circle' : 'check-circle';

                    return '<div class="d-flex align-items-center">
                            <div class="d-flex">
                                <span>
                                    <a href="javascript:void(0);" class="btn btn-outline-' . $statusClass . ' status"
                                       url="' . route('roles.changeStatus', urlencode(base64_encode($row->id))) . '"
                                       title="' . $status . '">
                                        <i class="far fa-' . $statusIcon . '"></i> ' . $status . '
                                    </a>
                                </span>
                                <a href="' . route('roles.edit', urlencode(base64_encode($row->id))) . '"
                                   class="btn btn-outline-info" title="Edit">
                                    <i class="fas fa-edit text-info"></i>
                                </a>
                                <span>
                                    <a class="btn btn-outline-danger btn-rounded flush-soft-hover deleteBtn"
                                       data-bs-toggle="tooltip" data-placement="top" title="Delete"
                                       href="javascript:void(0)"
                                       url="' . route('roles.destroy', urlencode(base64_encode($row->id))) . '">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>
                                </span>
                                <a href="' . route('roles.permissionIndex', urlencode(base64_encode($row->id))) . '"
                                   class="btn btn-outline-info" title="Configure Permissions">
                                    <i class="fa fa-key"></i>
                                </a>
                            </div>
                        </div>';
                })
                ->editColumn('created_at', function ($user) {
                    return [
                        'display' => e($user->created_at->format('m-d-Y')),
                        'timestamp' => $user->created_at->timestamp
                    ];
                })
                ->addColumn('status', function ($data) {
                    $badge = '<span data-dc="' . base64_encode($data->id) . '" class="badge badge-' . ($data->active ? 'success' : 'danger') . '">' . ($data->active ? 'Active' : 'Inactive') . '</span>';
                    return $badge;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.roles.index');
    }


    // public function createOld(Request $request)
    // {
    //     if ($request->isMethod('get')) {
    //         return view('admin.roles.createEdit');
    //     }

    //     $rules = [
    //         'role'        => 'required|regex:/^[a-zA-Z ]+$/u|min:1|max:255',
    //         'description' => 'required',
    //     ];

    //     $validation = Validator::make($request->all(), $rules);

    //     if ($validation->fails()) {

    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validation->errors()
    //         ]);
    //     }

    //     DB::beginTransaction();
    //     try {

    //         $role_exist = DB::table('roles')->where(['name' => $request->role, 'status' => '1'])->count();

    //         if ($role_exist > 0) {
    //             return response()->json([
    //                 'success' => false,
    //                 'errors' => ['role' => 'This Role is Already Exist!']
    //             ]);
    //         }

    //         $new_role = new Role();
    //         $new_role->role = $request->role;
    //         $new_role->description = $request->description;
    //         $new_role->status = '1';
    //         $new_role->save();


    //         DB::commit();
    //         return response()->json([
    //             'success' => true
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         // something went wrong
    //         return $e;
    //     }
    // }


    // public function roleUpdate(Request $request)
    // {
    //     $role_id = base64_decode($request->id);
    //     // dd($role_id);
    //     $rules = [
    //         'role'          => 'required|regex:/^[a-zA-Z ]+$/u|min:1|max:255',
    //         'description'   => 'required',
    //     ];

    //     $validation = Validator::make($request->all(), $rules);

    //     if ($validation->fails()) {

    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validation->errors()
    //         ]);
    //     }
    //     DB::beginTransaction();
    //     try {

    //         $role_exist = DB::table('roles')
    //             ->where('role', $request->role)
    //             ->where('status', '1')
    //             ->where('id', '<>', $role_id) // Exclude the current role ID
    //             ->count();

    //         if ($role_exist > 0) {
    //             return response()->json([
    //                 'success' => false,
    //                 'errors' => ['role' => 'This Role is Already Exist!']
    //             ]);
    //         }
    //         $new_role = Role::find($role_id);

    //         if ($new_role) {
    //             $new_role->role = $request->role;
    //             $new_role->description = $request->description;
    //             $new_role->status = '1';
    //             $new_role->save();
    //         }

    //         DB::commit();
    //         return response()->json([
    //             'success' => true
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         // something went wrong
    //         return $e;
    //     }
    // }

    // public function roleDelete(Request $request)
    // {
    //     $role_id = base64_decode($request->id);

    //     DB::beginTransaction();
    //     try {

    //         $users = User::where('role_id', $role_id)->first();

    //         if ($users) {

    //             return response()->json([
    //                 'success' => false
    //             ]);
    //         }

    //         $privacy = Role::find($role_id);
    //         $privacy->status = '2'; //Association Status in delete mode
    //         $privacy->save();

    //         DB::commit();
    //         return response()->json([
    //             'success' => true
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         // something went wrong
    //         return $e;
    //     }
    // }


    public function changeStatus($id)
    {
        $role_id = base64_decode(urldecode($id));
        $role = Role::find($role_id);
        $role->active = !$role->active;
        $role->save();

        return response()->json([
            'success' => true,
            'msg' => 'Status change successfully.'
        ]);
    }


    public function getAddPermissionPage(Request $request)
    {
        // ->whereNotIn('parent_id','0')
        $role_id = base64_decode($request->id);

        $role_data = DB::table('roles')->where(['active' => true, 'id' => $role_id])->first();
        // dd($role_data);
        $action_route_count = DB::table('role_permissions')->where(['role_id' => $role_id, 'status' => '1'])->count();
        $action_route = DB::table('role_permissions')->where(['role_id' => $role_id, 'status' => '1'])->first();
        // dd($action_route);        
        $permission  = DB::table('action_masters')->where(['route_group' => '', 'status' => '1', 'parent_id' => '0'])->get();

        return view('admin.roles.permission', compact('permission', 'role_id', 'action_route', 'role_data', 'action_route_count'));
    }


    public function addPermission(Request $request)
    {
        //  dd($request->business_id);
        $this->validate($request, [
            'permissions'      => 'required',
        ]);
        DB::beginTransaction();
        try {
            foreach ($request->permissions as $permissions) {
                $data[] = $permissions;
            }
            $permissions_id = implode(',', $data);
            $permission_data =
                [
                    'role_id'        => $request->role_id,
                    'permission_id'  => $permissions_id,
                    'status'         => '1'
                ];
            $count = DB::table('role_permissions')->where('role_id', $request->role_id)->count();
            if ($count > 0) {
                DB::table('role_permissions')->where(['role_id' => $request->role_id])->update($permission_data);
            } else {
                $user_id = DB::table('role_permissions')->insertGetId($permission_data);
            }

            DB::commit();
            return redirect('/roles-list')->with('success', 'Permission updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }

    
    public function create()
    {
        return view('admin.roles.createEdit');
    }

    
    public function edit(Request $request)
    {
        $id = base64_decode(urldecode($request->id));

        $data['currentRole'] = Role::find($id);
        return view('admin.roles.createEdit', $data);
    }


    public function store(Request $request)
    {
        $role_id = base64_decode(urldecode($request->input('id')));
        $rules = [
            'name'          => 'required|regex:/^[a-zA-Z ]+$/u|unique:roles,name,' . ($role_id ?? null),
            'description'   => 'required',
        ];
        $data = $request->all();
        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validation->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $role = Role::find($role_id);
            if ($role) {
                $role->update($data);
            } else {
                $role = Role::create($data);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Role saved successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error saving role'
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        dd($id);
    }



    public function permissionIndex($id) {
        $data['role'] = Role::find(base64_decode(urldecode($id)));
        $data['permissions'] = Permission::orderBy('menu','asc')->get()->groupBy(['menu', 'parent_label']);
        return view('admin.roles.editPermissions', $data);
    }

    public function permissionStore(Request $request,$id) {
        $data = $request->all();
        $role = Role::find(base64_decode(urldecode($id)));
        DB::beginTransaction();
        try {
            $role->permissions()->sync($data['permissions']);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'data' => $th,
                'msg' => 'Error Occurred'
            ]);
        }
        return response()->json([
            'success' => true,
            'msg' => 'Saved Successfully'
        ]);
    }
}
