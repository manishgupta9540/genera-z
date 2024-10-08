<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::select('id','name','description','created_at','status')->whereIn('status',[0,1])
                    ->orderBy('id','desc')
                    ->latest()->get();
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
                $edit_url = url('/category/edit',['id'=>base64_encode($row->id)]);

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

        return view('admin.categories.index');
    }

    public function create(Request $request)
    {
        if($request->isMethod('get'))
        {
            return view('admin.categories.create');
        }

        $rules = [
            'name'  => 'required|min:1|max:255',
            //'description'  => 'required',
        ];

        $msgs = [
            'name.required'         => 'Name Field  is required.',
        ];

        $request->validate($rules,$msgs);


        DB::beginTransaction();
        try{

            $data = [
                'name'        => $request->input('name'),
                'description' => $request->input('description'),
                'status'      => 1,
                'created_at'  => date('Y-m-d H:i:s')
            ];
            DB::table('categories')->insert($data);

            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Save Successfully',
                'url'=> route('category.index'),
            ]);
        }
        catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }

    }

    public function categoryEdit(Request $request)
    {
        $cate_id = base64_decode($request->id);

        $category = DB::table("categories")->where('id', $cate_id)->first();
        return view('admin.categories.edit',compact('category'));

    }

    public function categoryUpdate(Request $request)
    {
        $cate_id = base64_decode($request->id);

        $rules = [
            'name'  => 'required|min:1|max:255',
            //'description'  => 'required',
        ];

        $msgs = [
            'name.required'         => 'Name Field  is required.',
        ];

        $request->validate($rules,$msgs);


        DB::beginTransaction();
        try{

            $data1 =   DB::table('categories')->where('id',$cate_id)->first();
            $status = $data1->status;

            $data = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            DB::table('categories')->where('id',$cate_id)->update($data);

            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Category Update Successfully',
                'url'=> route('category.index'),
            ]);
        }
        catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function categoryDelete(Request $request)
    {
        $cate_id = base64_decode($request->id);
        DB::beginTransaction();
        try{
            $course = Course::where('category_id',$cate_id)->first();
            if($course){

                return response()->json([
                    'success' => false
                ]);
            }
            $blog = Category::find($cate_id);
            $blog->status = 2;
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

    public function categoryStatus(Request $request)
    {
        $cate_id=base64_decode($request->id);
        $type = base64_decode($request->type);

        $user = Category::find($cate_id);

        $user->status = !$user->status;
        $user->save();

        return response()->json([
            'success'=>true,
            'type' => $type,
            'message'=>'Status change successfully.'
        ]);
    }
}
