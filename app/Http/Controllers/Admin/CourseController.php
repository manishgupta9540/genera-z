<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
use App\Models\CoursePrice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\Models\CourseSkill;
use App\Models\Objective;
use App\Models\PriceOption;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Course::with('category')->select('id', 'title', 'image', 'overview', 'category_id', 'created_at', 'status')->whereIn('status', [0, 1])
                ->orderBy('id', 'desc')
                ->latest()->get();
            // dd($data);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action  = "";
                    if ($row->status == 1) {
                        $action_1 = '<span data-d="' . base64_encode($row->id) . '"><a href="javascript:;" class="btn btn-outline-dark status" data-id="' . base64_encode($row->id) . '" data-type="' . base64_encode('disable') . '" data-name="' . $row->name . '" title="Deactivate"><i class="far fa-times-circle"></i> Deactivate</a></span>
                                <span data-a="' . base64_encode($row->id) . '" class="d-none"><a href="javascript:;" class="btn btn-outline-success status" data-id="' . base64_encode($row->id) . '" data-type="' . base64_encode('enable') . '" data-name="' . $row->name . '" title="Active"><i class="far fa-check-circle"></i> Activate</a></span>';
                    } else {
                        $action_1 = '<span class="d-none" data-d="' . base64_encode($row->id) . '"><a href="javascript:;" class="btn btn-outline-dark status" data-id="' . base64_encode($row->id) . '" data-type="' . base64_encode('disable') . '" data-name="' . $row->name . '" title="Deactivate"><i class="far fa-times-circle"></i> Deactivate</a></span>
                                <span data-a="' . base64_encode($row->id) . '"><a href="javascript:;" class="btn btn-outline-success status" data-id="' . base64_encode($row->id) . '" data-type="' . base64_encode('enable') . '" data-name="' . $row->name . '"  title="Active"><i class="far fa-check-circle"></i> Activate</a></span>';
                    }
                    $edit_url = url('/course/edit', ['id' => base64_encode($row->id)]);

                    $action_2 = '<a href="' . $edit_url . '" class="btn btn-outline-info" title="Edit"><i class="fas fa-edit text-info"></i></a>';

                    $action_3 = '<span><a class="btn btn-outline-danger btn-rounded flush-soft-hover deleteBtn" data-bs-toggle="tooltip" data-placement="top" title=""
                            data-bs-original-title="Delete" href="javascript:void(0)" data-id="' . base64_encode($row->id) . '">
                            <i class="fas fa-trash text-danger"></i>
                            </a></span>';

                    $add_module = url('/course/add_module', ['id' => base64_encode($row->id)]);
                    $action_4 = '<a href="' . $add_module . '" class="btn btn-sm btn-clean btn-icon" title="add"><i class="fas fa-plus text-warning"></i></a>';

                    $action =   '<div class="d-flex align-items-center">
                                <div class="d-flex">
                                ' . $action_1 . '
                                ' . $action_2 . '
                                ' . $action_3 . '
                                ' . $action_4 . '
                                </div>
                            </div>';

                    $action = '';
                    if (Auth::user()->user_type != '0') {
                        $childs = Helper::get_user_permission();
                        $permissions = DB::table('action_masters')->whereIn('id', $childs)->get();
                        // dd($permissions);
                        foreach ($permissions as $item) {
                            $action .= '<div class="d-flex align-items-center">
                                                ' . (isset($item->action) && $item->action == 'course-create' ? $action_1 : null) . '
                                                ' . (isset($item->action) && $item->action == 'course/edit' ? $action_2 : null) . '
                                                ' . (isset($item->action) && $item->action == 'course-delete' ? $action_3 : null) . '

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
                    if ($data->status == 0) {
                        return '<span data-dc="' . base64_encode($data->id) . '" class="badge badge-danger">Inactive</span>
                        <span data-ac="' . base64_encode($data->id) . '" class="badge badge-success d-none">Active</span>';
                    } else {
                        return '<span data-dc="' . base64_encode($data->id) . '" class="badge badge-danger d-none">Inactive</span>
                        <span data-ac="' . base64_encode($data->id) . '" class="badge badge-success">Active</span>';
                    }
                })
                ->editColumn('image', function ($data) {
                    return '<img src="' . Storage::url('uploads/course/' . $data['image']) . '" style="width:100px; height:100px;"/>';
                })

                ->rawColumns(['action', 'status', 'image'])
                ->make(true);
        }

        return view('admin.courses.index');
    }

    public function create(Request $request)
    {
        $data['title'] = 'Create Course';
        $data['categories'] = Category::where('status', '1')->get();
        $data['skills'] = Skill::where('status', '1')->get();
        return view('admin.courses.createEdit', $data);
    }

    public function courseEdit(Request $request)
    {
        $cate_id = base64_decode($request->id);
        $data['title'] = 'Edit Course';
        $data['courseData'] = Course::where('id', $cate_id)->first();
        $data['categories'] = Category::where('status', '1')->get();
        $data['skills'] = Skill::get();
        $data['objectives'] = Objective::where('course_id', $data['courseData']->id)->get();
        $data['price'] = CoursePrice::where('course_id', $data['courseData']->id)->get();
        // dd($data);
        return view('admin.courses.createEdit', $data);
    }

    public function courseDeletePrice(Request $request)
    {
        $price_id = base64_decode($request->id);

        DB::beginTransaction();
        try {
            $blog = CoursePrice::find($price_id);
            $blog->delete();

            DB::commit();
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }



    public function courseUpdate(Request $request)
    {
        // dd($request->all());
        $id = base64_decode($request->id);

        $rules = [
            'title'             => 'required',
            'overview'          => 'required',
            'description'       => 'required',
            'summary'           => 'required',
            'category_id'       => 'required',
            'image'             => 'nullable|mimes:jpeg,jpg,bmp,png,gif,svg',
            'skill_id'          => 'required',
            'course_duration'   => 'required',
            'total_modules'     => 'required',
            'pricing'           => 'required',
            'rating'            => 'required|numeric|min:1|max:5',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);
        }

        $old_image = Course::find($id);

        DB::beginTransaction();
        try {

            if ($request->file('image')) {
                $image = $request->file('image');
                $date = date('YmdHis');
                $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                $random_no = substr($no, 0, 2);
                $final_image_name = $date . $random_no . '.' . $image->getClientOriginalExtension();

                $destination_path = public_path('/uploads/course/');
                if (!File::exists($destination_path)) {
                    File::makeDirectory($destination_path, $mode = 0777, true, true);
                }
                $image->move($destination_path, $final_image_name);
            } else {
                $final_image_name = $old_image->image;
            }

            $data1 =   DB::table('courses')->where('id', $id)->first();
            $status = $data1->status;

            $subscription = $request->input('subscription');

            $skills = implode(',', $request->input('skill_id'));

            if ($subscription == 'one time') {
                $data = [
                    'title'             => $request->input('title'),
                    'headline'          => $request->input('headline'),
                    'overview'          => $request->input('overview'),
                    'description'       => $request->input('description'),
                    'summary'           => $request->input('summary'),
                    'category_id'       => $request->input('category_id'),
                    'image'             => !empty($final_image_name) ? $final_image_name : NULL,
                    'skill_id'          => $skills,
                    'subscription'       => $request->input('subscription'),
                    'rating'            => (float)$request->input('rating'),
                    'course_duration'   => $request->input('course_duration'),
                    'plan_details'      => $request->input('plan_details'),
                    'total_modules'     => $request->input('total_modules'),
                    'pricing'           => $request->input('pricing')[0],
                    'status'            => $status,
                    'updated_at'        => now()
                ];

                DB::table('courses')->where('id', $id)->update($data);
            } else {

                $data = [
                    'title'      => $request->input('title'),
                    'overview'   => $request->input('overview'),
                    'category_id'       => $request->input('category_id'),
                    'image'             => !empty($final_image_name) ? $final_image_name : NULL,
                    'skill_id'          => $skills,
                    'subscription'       => $request->input('subscription'),
                    'rating'            => (float)$request->input('rating'),
                    'course_duration'   => $request->input('course_duration'),
                    'short_description'   => $request->input('short_description'),
                    'short_overview'   => $request->input('short_overview'),
                    'total_modules'     => $request->input('total_modules'),
                    'status'               => 1,
                    'updated_at'           => now()
                ];

                DB::table('courses')->where('id', $id)->update($data);

                foreach ($request->subscription_plan as $key => $plan) {

                    if (isset($request->price_id[$key])) {
                        $coursePrice = CoursePrice::where('id', $request->price_id[$key])->first();
                        $coursePrice->subscription_plan = $request->subscription_plan[$key];
                        $coursePrice->pricing = $request->pricing[$key];
                        $coursePrice->subscription_details = $request->subscription_details[$key];
                        $coursePrice->access_duration = $request->access_duration[$key];
                        $coursePriceArray = $coursePrice->getAttributes();
                        // Update the course_prices table with the correct coursePrice record
                        DB::table('course_prices')->where('id', $coursePrice->id)->update($coursePriceArray);
                    } else {
                        $coursePrice = new CoursePrice();
                        $coursePrice->course_id = $id;
                        $coursePrice->subscription_plan = $request->subscription_plan[$key];
                        $coursePrice->pricing = $request->pricing[$key];
                        $coursePrice->subscription_details = $request->subscription_details[$key];
                        $coursePrice->access_duration = $request->access_duration[$key];
                        $coursePrice->save();
                    }
                }
            }
            DB::commit();
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'title' => 'required',
            'headline' => 'required',
            'overview' => 'required',
            'description' => 'required',
            'summary'     => 'required',
            'category_id' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,bmp,png,gif,svg',
            'skills'  => 'required|array',
            'duration' => 'required|numeric|min:1',
            'total_modules' => 'required|numeric|min:1',
            'price' => 'sometimes|max:16777215',
            'rating' => 'required|numeric|min:1|max:5',
        ]);
        $id = base64_decode(urldecode($request->id));
        $data = $request->all();

        if ($request->file('image')) {
            $image = $request->file('image');
            $data['image'] = now()->format('YmdHis') . str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT) . '.' . $image->getClientOriginalExtension();
            $destination_path = 'uploads/course';
            $image->storeAs($destination_path, $data['image'], 'public');
        }
        else {
            unset($data['image']);
        }
        DB::beginTransaction();
        try {
            DB::enableQueryLog();
            $course = Course::updateOrCreate(['id' => $id], $data);
            //  dd(DB::getQueryLog());
            // dd($course);
            if (isset($data['objectives']) && count($data['objectives'])) {
                foreach ($data['objectives'] as $key => $value) {
                    Objective::updateOrCreate([
                        'id' => $key
                    ],[
                        'course_id' => $course->id,
                        'content' => $value
                    ]);
                }
            }
            if (isset($data['pricingOptions']) && count($data['pricingOptions'])) {
                foreach ($data['pricingOptions'] as $key => $value) {
                    $value['course_id'] = $course->id;
                    PriceOption::updateOrCreate([
                        'id' => $key
                    ],$value);
                }
            }
            $course->skills()->sync($data['skills']);

            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Course Saved Successfully',
                'url' => route('course.index')
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => $th
            ]);
        }
    }


    public function courseDelete(Request $request)
    {
        $cate_id = base64_decode($request->id);
        DB::beginTransaction();
        try {
            $blog = Course::find($cate_id);
            $blog->status = '2';
            $blog->save();


            DB::commit();
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }

    public function courseStatus(Request $request)
    {
        $cate_id = base64_decode($request->id);
        //$user = RoleMaster::find($role_id);
        $type = base64_decode($request->type);

        if ($type == 'disable') {
            $user = Course::find($cate_id);
            $user->status = '0';
            $user->save();

            return response()->json([
                'success' => true,
                'type' => $type,
                'message' => 'Status change successfully.'
            ]);
        } elseif ($type == 'enable') {
            $user = Course::find($cate_id);
            $user->status = '1';
            $user->save();

            return response()->json([
                'success' => true,
                'type' => $type,
                'message' => 'Status change successfully.'
            ]);
        }
    }

    public function add_module(Request $request)
    {
        $course_id = base64_decode($request->id);

        $courses = DB::table('courses')->where('id', $course_id)->first();

        return view('admin.courses.add_module', compact('courses'));
    }

    public function priceOptionDestroy($id)
    {
        $id = base64_decode($id);
        $priceOption = PriceOption::find($id);

        if ($priceOption) {
            $priceOption->delete();
            return response()->json(['success' => 'Price option deleted successfully.']);
        }

        return response()->json(['error' => 'Price option not found.'], 404);
    }
}
