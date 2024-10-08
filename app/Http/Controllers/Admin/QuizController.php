<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Helpers\Helper;
use App\Models\Quiz;
use App\Models\Material;
use App\Models\SubModule;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Quiz::select('id','title','start_date','start_time','created_at','status')->whereIn('status',[0,1])
                    ->orderBy('id','desc')
                    ->latest()->get();
                    // dd($data);
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
                $edit_url = url('/quize/edit',['id'=>base64_encode($row->id)]);

                $action_2 = '<a href="'.$edit_url.'" class="btn btn-outline-info" title="Edit"><i class="fas fa-edit text-info"></i></a>';

                $action_3 = '<span><a class="btn btn-outline-danger btn-rounded flush-soft-hover deleteBtn" data-bs-toggle="tooltip" data-placement="top" title=""
                            data-bs-original-title="Delete" href="javascript:void(0)" data-id="'.base64_encode($row->id).'">
                            <i class="fas fa-trash text-danger"></i>
                            </a></span>';

                // $add_module = url('/quize/question', ['id' => base64_encode($row->id)]);
                // $action_4 = '<a href="' . $add_module . '" class="btn btn-outline-primary" title="Question"><i class="fas fa-question text-info"></i></a></a>';
                
                $add_module = url('question-list');
                $action_5 = '<a href="' . $add_module . '" class="btn btn-outline-primary" title="Question"><i class="fas fa-info text-info"></i></a></a>'; 

                $action =   '<div class="d-flex align-items-center">
                                <div class="d-flex">
                                '.$action_1.'
                                '.$action_2.'
                                '.$action_3.'
                               
                                '.$action_5.'
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
                                           
                                            ' . $action_5 . '
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
                ->editColumn('image', function($data){
                    $url = url("uploads/assignment/".$data->image);        
                    return '<img src="'. $url .'" style="width:100px; height:100px;"/>'; 

                })  
                
                ->rawColumns(['action','status','image'])
                ->make(true);
        }

        return view('admin.quize.index');   
    }


    public function create(Request $request)
    {
        $ci_id = base64_decode($request->id);
        // dd($ci_id);
        $subModule = SubModule::where('id',$ci_id)->first();
        // dd($course);
        return view('admin.quize.create',compact('subModule'));
    }

    public function quizeStore(Request $request)
    {
        $rules = [
            'title'         => 'required',
            'passing_score' => 'required',
            'description'   => 'required',
            'start_date'    => 'required',
            'start_time'    => 'required',
            'default_marks'  => 'required',
            'negative_marks' => 'required',
            'time_limit'     => 'required',
            
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

            // if($request->file('image'))
            // {
            //     $image = $request->file('image');
            //     $date = date('YmdHis');
            //     $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
            //     $random_no = substr($no, 0, 2);
            //     $final_image_name = $date.$random_no.'.'.$image->getClientOriginalExtension();
    
            //     $destination_path = public_path('/uploads/assignment/');
            //     if(!File::exists($destination_path))
            //     {
            //         File::makeDirectory($destination_path, $mode = 0777, true, true);
            //     }
            //     $image->move($destination_path , $final_image_name);

            // }

            $data = [
                'sub_module_id' => $request->input('cours_m_id'),
                'created_by'       => Auth::user()->id,
                'title'            => $request->input('title'),
                'passing_score'    => $request->input('passing_score'),
                'description'      => $request->input('description'),
                'start_date'        => $request->input('start_date'),
                'start_time'        => $request->input('start_time'),
                'default_marks'     => $request->input('default_marks'),
                'negative_marks'    => $request->input('negative_marks'),
                'time_limit'        => $request->input('time_limit'),
                'status'            => 1,
                'created_at'        => date('Y-m-d H:i:s')
            ];
            // dd($data);
            DB::table('quizzes')->insert($data);

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

    public function quizeEdit(Request $request)
    {
        $quize_id = base64_decode($request->id);
        
        $quize = DB::table("quizzes")->where('id', $quize_id)->first();
        
        return view('admin.quize.edit',compact('quize'));
    
    }

    public function quizeUpdate(Request $request)
    {
        $quize_id = base64_decode($request->id);

        $course_m_id = base64_decode($request->cours_m_id);
        // dd($course_m_id);
        $rules = [
            'title'         => 'required',
            'passing_score' => 'required',
            'description'   => 'required',
            'start_date'    => 'required',
            'start_time'    => 'required',
            'default_marks'  => 'required',
            'negative_marks' => 'required',
            'time_limit'     => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);

        }

       // $old_image = DB::table('assignments')->where('id',$quize_id)->first();
        // dd($old_image);
        DB::beginTransaction();
        try{

            // if($request->file('image'))
            // {
            //     $image = $request->file('image');
            //     $date = date('YmdHis');
            //     $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
            //     $random_no = substr($no, 0, 2);
            //     $final_image_name = $date.$random_no.'.'.$image->getClientOriginalExtension();
    
            //     $destination_path = public_path('/uploads/assignment/');
            //     if(!File::exists($destination_path))
            //     {
            //         File::makeDirectory($destination_path, $mode = 0777, true, true);
            //     }
            //     $image->move($destination_path , $final_image_name);
            // }
            // else
            // {
            //     $final_image_name = $old_image->image;
            // }

            $data1 =   DB::table('quizzes')->where('id',$quize_id)->first();
            $status = $data1->status;


            $data = [
                'sub_module_id' => $course_m_id,
                'created_by'    => Auth::user()->id,
                'title'            => $request->input('title'),
                'passing_score'    => $request->input('passing_score'),
                'description'      => $request->input('description'),
                'start_date'        => $request->input('start_date'),
                'start_time'        => $request->input('start_time'),
                'default_marks'     => $request->input('default_marks'),
                'negative_marks'    => $request->input('negative_marks'),
                'time_limit'        => $request->input('time_limit'),
                'status'           => $status,
                'updated_at'       => date('Y-m-d H:i:s')
            ];

            DB::table('quizzes')->where('id',$quize_id)->update($data);

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

    public function quizeDelete(Request $request)
    {
        $q_id = base64_decode($request->id);
        DB::beginTransaction();
        try{
            $blog = Quiz::find($q_id);
            $blog->status = '2';
            $blog->save();


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

    public function quizeStatus(Request $request)
    {
        $qz_id=base64_decode($request->id);
        //$user = RoleMaster::find($role_id);
        $type = base64_decode($request->type);
        
        if($type == 'disable')
        { 
            $user = Quiz::find($qz_id);
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
            $user = Quiz::find($qz_id);
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
