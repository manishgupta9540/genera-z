<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function courseModuleList(Request $request)
    {
        if ($request->ajax()) {
            $data = Module::with('course')->select('id','course_id','name','created_at','status')->whereIn('status',[0,1])
                   ->orderBy('id','desc')
                   ->latest()->get();
                    // dd($data);
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($row){
                $action  ="";
                if($row->status==1)
                {
                    $action_1 = '<span data-d="'.base64_encode($row->id).'"><a href="javascript:;" class="btn btn-outline-dark status" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('disable').'" data-name="'.$row->name.'" title="Deactivate"><i class="far fa-times-circle"></i> Deactivate</a></span>
                                <span data-a="'.base64_encode($row->id).'" class="d-none"><a href="javascript:;" class="btn btn-outline-success status" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('enable').'" data-name="'.$row->name.'" title="Active"><i class="far fa-check-circle"></i> Activate</a></span>';

                }
                else
                {
                    $action_1 = '<span class="d-none" data-d="'.base64_encode($row->id).'"><a href="javascript:;" class="btn btn-outline-dark status" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('disable').'" data-name="'.$row->name.'" title="Deactivate"><i class="far fa-times-circle"></i> Deactivate</a></span>
                                <span data-a="'.base64_encode($row->id).'"><a href="javascript:;" class="btn btn-outline-success status" data-id="'.base64_encode($row->id).'" data-type="'.base64_encode('enable').'" data-name="'.$row->name.'"  title="Active"><i class="far fa-check-circle"></i> Activate</a></span>';
                }
                $edit_url = url('/course/module/edit',['id'=>base64_encode($row->id)]);

                $action_2 = '<a href="'.$edit_url.'" class="btn btn-outline-info" title="Edit"><i class="fas fa-edit text-info"></i></a>';

                $action_3 = '<span><a class="btn btn-outline-danger btn-rounded flush-soft-hover deleteBtn" data-bs-toggle="tooltip" data-placement="top" title=""
                            data-bs-original-title="Delete" href="javascript:void(0)" data-id="'.base64_encode($row->id).'">
                            <i class="fas fa-trash text-danger"></i>
                            </a></span>';

                $add_module = route('sub-module.create', base64_encode($row->id));
                $action_4 = '<a href="' . $add_module . '" class="btn btn-sm btn-clean btn-icon" title="add"><i class="fas fa-plus text-warning"></i></a>';

                $action =   '<div class="d-flex align-items-center">
                                <div class="d-flex">
                                '.$action_1.'
                                '.$action_2.'
                                '.$action_3.'
                                '.$action_4.'
                                </div>
                            </div>';

                    $action = '';
                    if(Auth::user()->user_type != '0'){
                        $childs = Helper::get_user_permission();
                        $permissions = DB::table('action_masters')->whereIn('id', $childs)->get();
                        // dd($permissions);
                        foreach ($permissions as $item){
                            $action .= '<div class="d-flex align-items-center">
                                                '.(isset($item->action) && $item->action == 'course-create' ? $action_1 : null).'
                                                '.(isset($item->action) && $item->action == 'course/edit' ? $action_2 : null).'
                                                '.(isset($item->action) && $item->action == 'course-delete' ? $action_3 : null).'

                                        </div>';
                        }
                    } else {
                        $action = '<div class="d-flex align-items-center">
                                        <div class="d-flex">
                                            ' . $action_1 . '
                                            ' . $action_2 . '
                                            ' . $action_3 . '
                                            ' . $action_4 . '
                                        </div>
                                    </div>';
                    }
                    return $action;
                })

                ->editColumn('created_at', function ($user) {
                    return [
                    'display' => e($user->created_at->format('m-d-Y')),
                    'timestamp' => $user->created_at->timestamp
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

                ->rawColumns(['action','status'])
                ->make(true);
        }

        return view('admin.courseModules.index');
    }

    public function courseModuleCreate(Request $request)
    {
        $course_id = $request->course_id;

        $rules = [
            'module_name.*' => 'required',
        ];

        $msgs = [
            'module_name.*.required' => 'Module name is required.',

        ];

        $request->validate($rules, $msgs);

        // Fetch the course and validate the total modules
        $course = Course::find($course_id);
        if (!$course) {
            return response()->json([
                'success' => false,
                'msg' => 'Course not found.'
            ]);
        }

        $totalModules = $course->total_modules;
        $existingModulesCount = Module::where('course_id', $course_id)->count();
        $newModulesCount = count($request->module_name);

        if ($existingModulesCount + $newModulesCount > $totalModules) {
            return response()->json([
                'success' => false,
                'msg' => 'You have exceeded the allowed number of modules. Maximum allowed is ' . $totalModules . '.'
            ]);
        }

        DB::beginTransaction();
        try {
            foreach ($request->module_name as $module) {
                Module::create([
                    'name' => $module,
                    'course_id' => $course_id,
                    'status' => 1,
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'url' => route('course-module-list'),
                'msg' => 'Saved Successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error occurred while adding modules: ' . $e->getMessage()
            ]);
        }
    }



    public function courseModuleEdit(Request $request)
    {
        $module_id = base64_decode($request->id);
        $moduleData = Module::where('id', $module_id)->first();
        return view('admin.courseModules.edit',compact('moduleData'));
    }

    public function courseModuleUpdate(Request $request)
    {
        $module_id = decrypt($request->id);
        // dd($module_id);
        $rules = [
           'name' => 'required',
        ];
        $msgs = [
            'name.required'    => 'Module name is required.',
        ];


        $request->validate($rules,$msgs);

        DB::beginTransaction();
        try{
            $data = [
                'name' => $request->input('name')
            ];
            Module::updateOrCreate([
                'id' => $module_id
            ],[
                'name' => $request->name
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'url'    =>url('course-module-list'),
                'msg'    => 'Module Updated Successfully'
            ]);
        }
        catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }


    public function moduleDelete(Request $request)
    {
        $cate_id = base64_decode($request->id);
        DB::beginTransaction();
        try{
            $blog = Module::find($cate_id);
            $blog->delete();

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

    public function moduleStatus(Request $request)
    {
        $cate_id=base64_decode($request->id);
        //$user = RoleMaster::find($role_id);
        $type = base64_decode($request->type);

        $user = Module::find($cate_id);
        $user->status = !$user->status;
        $user->save();

        return response()->json([
            'success'=>true,
            'type' => $type,
            'message'=>'Status change successfully.'
        ]);
    }
}
