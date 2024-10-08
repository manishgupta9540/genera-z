<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\SubModule;
use App\Models\Assement;
use App\Models\Module;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class SubModuleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SubModule::with('module.course','assignments')
                            ->select('id', 'module_id', 'name', 'created_at', 'status')
                            ->whereHas('module.course')
                            ->whereIn('status', [0, 1])
                            ->orderBy('id', 'desc')
                            ->latest()->get();
                            // dd( $data);
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($row){

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
                $edit_url = url('/sub/module/edit',['id'=>base64_encode($row->id)]);

                $action_2 = '<a href="'.$edit_url.'" class="btn btn-outline-info" title="Edit"><i class="fas fa-edit text-info"></i></a>';

                $action_3 = '<span><a class="btn btn-outline-danger btn-rounded flush-soft-hover deleteBtn" data-bs-toggle="tooltip" data-placement="top" title=""
                            data-bs-original-title="Delete" href="javascript:void(0)" data-id="'.base64_encode($row->id).'">
                            <i class="fas fa-trash text-danger"></i>
                            </a></span>';

                $action_4 = '<a href="' . route('assignmentIndex',urlencode(base64_encode($row->id)) ) . '" class="btn btn-outline-primary " title="Assignment">Assignment</a></a>';

                $action_5 = '<a href="' . route('materialsIndex',urlencode(base64_encode($row->id))) . '" class="btn btn-outline-primary" title="Question">Course Materials</a></a>';

                $action =   '<div class="d-flex">
                                <div class="d-flex align-items-center text-nowrap">
                                '.$action_1.'
                                '.$action_2.'
                                '.$action_3.'
                                '.$action_4.'
                                '.$action_5.'
                                </div>
                            </div>';
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
                ->addColumn('course_name', function($row) {
                    return $row->module->course->title ?? 'N/A'; // Add a course name column
                })
                ->addColumn('moduleName', function($row) {
                    return $row->module->name ?? 'N/A'; // Add a course name column
                })
                ->rawColumns(['action','status','course_name','moduleName'])
                ->make(true);
        }

        return view('admin.submodule.index');
    }

    public function create(Request $request,$id)
    {
        $id = base64_decode($id);

        $courseModule = Module::where('id',$id)->where('status','1')->first();
        if ($courseModule) {
            return view('admin.submodule.create',compact('courseModule'));
        }
        return redirect()->back()->with('msg','Module is inactive.');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $moduleId = base64_decode($request->module_id);

        $rules = [
            'name.*'   => 'required',
        ];

        $msgs = [
            'name.*.required'       => 'Module name is required.',
        ];

        $request->validate($rules,$msgs);

        DB::beginTransaction();
        try{
            $modulename = $request->input('name');
            // Create an array to store option data
            $modulenameData = [];

            foreach ($modulename as $module) {
                $modulenameData[] = SubModule::create([
                    'name' => $module,
                    'module_id' => $moduleId,
                    'status' => 1,
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Saved Successfully',
                'url' => route('sub-module-list')
            ]);
        }
        catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }



    public function subModuleEdit(Request $request)
    {
        $sub_module_id = base64_decode($request->id);
        // dd($sub_module_id);
       // $assements = Assement::where('status','1')->get();
        $subModule = DB::table('sub_modules')->where('id',$sub_module_id)->first();
        // dd($subModule);
        return view('admin.submodule.edit',compact('subModule'));

    }

    public function subModuleUpdate(Request $request)
    {
        // dd($request->all());
        $sub_id = base64_decode($request->module_id);

        $rules = [
            'name' => 'required',
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

            $data1 =   DB::table('sub_modules')->where('module_id',$sub_id)->first();
            $status = $data1->status;

            $data = [
                'module_id'       => $sub_id,
                'name'            => $request->input('name'),
                'status'          => $status,
                'updated_at'      => date('Y-m-d H:i:s')
            ];

            DB::table('sub_modules')->where('module_id',$sub_id)->update($data);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Course sub Module Updated Successfully'
            ]);
        }
        catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }

    public function subModuleDelete(Request $request)
    {
        $cate_id = base64_decode($request->id);
        DB::beginTransaction();
        try{
            // $course = SubModule::where('category_id',$cate_id)->first();
            // if($course){

            //     return response()->json([
            //         'success' => false
            //     ]);
            // }
            $blog = SubModule::find($cate_id);
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

    public function subModuleStatus(Request $request)
    {
        $sub_id=base64_decode($request->id);
        //$user = RoleMaster::find($role_id);
        $type = base64_decode($request->type);

        if($type == 'disable')
        {
            $user = SubModule::find($sub_id);
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
            $user = SubModule::find($sub_id);
            $user->status = '1';
            $user->save();

            return response()->json([
                'success'=>true,
                'type' => $type,
                'message'=>'Status change successfully.'
            ]);
        }
    }
}
