<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Certification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Hash;
use Carbon\Carbon;

class CertificationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Certification::with('courses')->whereIn('status',['0','1'])->select('id','certification_title','certificate_design','course_id','issuing_organization','created_at','status')->latest()->get();
           
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
                $edit_url = url('/certification/edit',['id'=>base64_encode($row->id)]);

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
                 
                ->editColumn('certificate_design', function($data){
                    $url = url("uploads/certification/".$data->certificate_design);        
                    return '<img src="'. $url .'" style="width:100px; height:100px;"/>'; 

                })  
                ->rawColumns(['action','role_id','certificate_design','status'])
                ->make(true);
        }

        return view('admin.certification.index');
    }

    public function create(Request $request)
    {
        
        if($request->isMethod('get'))
        {
            $courses = Course::where('status',1)->get();
            return view('admin.certification.create',compact('courses'));
        }
    
        $rules = [
            'certification_title'  => 'required|regex:/^[a-zA-Z ]+$/u|min:1|max:255',
            'issuing_organization' => 'required',
            'course_id'   => 'required',
            'description'  => 'required',
            'completion'   => 'required',
            'minimum_grade' => 'required',
            'certificate_design' => 'required|mimes:jpeg,jpg,bmp,png,gif,svg',

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
            if($request->file('certificate_design'))
            {
                $image = $request->file('certificate_design');
                $date = date('YmdHis');
                $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                $random_no = substr($no, 0, 2);
                $final_image_name = $date.$random_no.'.'.$image->getClientOriginalExtension();
    
                $destination_path = public_path('/uploads/certification/');
                if(!File::exists($destination_path))
                {
                    File::makeDirectory($destination_path, $mode = 0777, true, true);
                }
                $image->move($destination_path , $final_image_name);

            }

            $certi = new Certification();
            $certi->certification_title = $request->certification_title;
            $certi->issuing_organization = $request->issuing_organization;
            $certi->course_id = $request->course_id;
            $certi->description = $request->description;
            $certi->completion = $request->completion;
            $certi->minimum_grade = $request->minimum_grade;
            $certi->certificate_design = !empty($final_image_name) ? $final_image_name : NULL;
            $certi->status = '1';
            $certi->created_at = now(); // Alternatively, use Carbon::now() if you are not using Laravel 7+
            $certi->save();

            

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

    public function certificationEdit(Request $request)
    {
        $ci_id = base64_decode($request->id);

        $courses = DB::table('courses')->where('status','1')->get();
    
        $certification = DB::table("certifications")->where('id', $ci_id)->first();
    
        return view('admin.certification.edit',compact('certification','courses'));
    }

    public function certificationUpdate(Request $request)
    {
        $role_id = base64_decode($request->id);
        
        $rules = [
            'certification_title'  => 'required|regex:/^[a-zA-Z ]+$/u|min:1|max:255',
            'issuing_organization' => 'required',
            'course_id'   => 'required',
            'description'  => 'required',
            'completion'   => 'required',
            'minimum_grade' => 'required',
            'certificate_design' => 'nullable|mimes:jpeg,jpg,bmp,png,gif,svg',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);

        }

        $old_image = DB::table('certifications')->where('id',$role_id)->first();

        DB::beginTransaction();
        try{

            if($request->file('certificate_design'))
            {
                $image = $request->file('certificate_design');
                $date = date('YmdHis');
                $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                $random_no = substr($no, 0, 2);
                $final_image_name = $date.$random_no.'.'.$image->getClientOriginalExtension();
    
                $destination_path = public_path('/uploads/certification/');
                if(!File::exists($destination_path))
                {
                    File::makeDirectory($destination_path, $mode = 0777, true, true);
                }
                $image->move($destination_path , $final_image_name);
            }
            else
            {
                $final_image_name = $old_image->certificate_design;
            }

            $data1 =   DB::table('certifications')->where('id',$role_id)->first();
            $status = $data1->status;

            $data = [
                'certification_title'      => $request->input('certification_title'),
                'issuing_organization'     => $request->input('issuing_organization'),
                'course_id'                => $request->input('course_id'),
                'description'              => $request->input('description'),
                'completion'               => $request->input('completion'),
                'minimum_grade'            => $request->input('minimum_grade'),
                'certificate_design'       => !empty($final_image_name) ? $final_image_name : NULL,
                'status'                   => $status,
                'updated_at'               => date('Y-m-d H:i:s')
            ];

            DB::table('certifications')->where('id',$role_id)->update($data);

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

    public function certificationDelete(Request $request)
    {
        
        $role_id =base64_decode($request->id);
        $privacy = Certification::find($role_id);
        $privacy->status = '2'; //Association Status in delete mode
        $privacy->save();

        return response()->json(['success'=>true]);  
    }

    public function certificationStatus(Request $request)
    {
        $role_id=base64_decode($request->id);
        //$user = RoleMaster::find($role_id);
        $type = base64_decode($request->type);
        
        if($type == 'disable')
        { 
            $user = Certification::find($role_id);
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
            $user = Certification::find($role_id);
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
