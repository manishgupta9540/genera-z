<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Blog;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::select('id','title','image','name','created_at','status')->whereIn('status',[0,1])
                    ->orderBy('id','desc')
                    ->get();
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
                $edit_url = url('/blogs/edit',['id'=>base64_encode($row->id)]);

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
                    $url = url("uploads/blogs/".$data->image);        
                    return '<img src="'. $url .'" style="width:100px; height:100px;"/>'; 

                })  
                
                ->rawColumns(['action','status','image'])
                ->make(true);
        }

        return view('admin.blogs.index');   
    }

    public function create(Request $request)
    {
        if($request->isMethod('get'))
        {
            return view('admin.blogs.create');
        }

        $rules = [
            'title'        => 'required',
            'image'        => 'required|mimes:jpeg,jpg,bmp,png,gif,svg',
            'name'         => 'required',
            'description'  => 'required',
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

            if($request->file('image'))
            {
                $image = $request->file('image');
                $date = date('YmdHis');
                $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                $random_no = substr($no, 0, 2);
                $final_image_name = $date.$random_no.'.'.$image->getClientOriginalExtension();
    
                $destination_path = public_path('/uploads/blogs/');
                if(!File::exists($destination_path))
                {
                    File::makeDirectory($destination_path, $mode = 0777, true, true);
                }
                $image->move($destination_path , $final_image_name);

            }

            $data = [
                'title' => $request->input('title'),
                'image'     => !empty($final_image_name) ? $final_image_name:NULL,
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];
            DB::table('blogs')->insert($data);

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

    public function blogEdit(Request $request)
    {
        $blog_id = base64_decode($request->id);
        
        $blogs = DB::table("blogs")->where('id', $blog_id)->first();
        
        return view('admin.blogs.edit',compact('blogs'));
    
    }

    public function blogsUpdate(Request $request)
    {
        $blog_id = base64_decode($request->id);

        $rules = [
            'title'      => 'required',
            'image'      => 'nullable|mimes:jpeg,jpg,bmp,png,gif,svg',
            'name'       => 'required',
            'description'=> 'required',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);

        }

        $old_image = DB::table('blogs')->where('id',$blog_id)->first();

        DB::beginTransaction();
        try{

            if($request->file('image'))
            {
                $image = $request->file('image');
                $date = date('YmdHis');
                $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                $random_no = substr($no, 0, 2);
                $final_image_name = $date.$random_no.'.'.$image->getClientOriginalExtension();
    
                $destination_path = public_path('/uploads/blogs/');
                if(!File::exists($destination_path))
                {
                    File::makeDirectory($destination_path, $mode = 0777, true, true);
                }
                $image->move($destination_path , $final_image_name);
            }
            else
            {
                $final_image_name = $old_image->image;
            }

            $data1 =   DB::table('blogs')->where('id',$blog_id)->first();
            $status = $data1->status;


            $data = [
                'title' => $request->input('title'),
                'image' => !empty($final_image_name) ? $final_image_name:NULL,
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'status'      => $status,
                'updated_at'  => date('Y-m-d H:i:s')
            ];

            DB::table('blogs')->where('id',$blog_id)->update($data);

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

    public function blogDelete(Request $request)
    {
        $blog_id = base64_decode($request->id);
        DB::beginTransaction();
        try{
            $blog = Blog::find($blog_id);
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

    public function blogStatus(Request $request)
    {
        $blog_id=base64_decode($request->id);
        //$user = RoleMaster::find($role_id);
        $type = base64_decode($request->type);
        
        if($type == 'disable')
        { 
            $user = Blog::find($blog_id);
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
            $user = Blog::find($blog_id);
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
