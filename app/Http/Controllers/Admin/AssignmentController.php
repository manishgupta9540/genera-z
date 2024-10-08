<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Helpers\Helper;
use App\Models\Assignment;
use App\Models\Material;
use App\Models\SubModule;
use App\Models\User;
use App\Models\Payment;
use App\Notifications\AssignmentDueDate;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Assignment::with('sub_module')->select('id', 'title', 'duration', 'public_show', 'created_at', 'status')->whereIn('status', [0, 1])
                ->orderBy('id', 'desc')
                ->latest()->get();

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $edit_url = url('/assignment/edit', ['id' => base64_encode($row->id)]);
                    $action_2 = '<a href="' . $edit_url . '" class="btn btn-outline-info" title="Edit"><i class="fas fa-edit text-info"></i></a>';
                    $action_3 = '<span><a class="btn btn-outline-danger btn-rounded flush-soft-hover deleteBtn" data-bs-toggle="tooltip" data-placement="top" title=""
                                data-bs-original-title="Delete" href="javascript:void(0)" data-id="' . base64_encode($row->id) . '">
                                <i class="fas fa-trash text-danger"></i>
                                </a></span>';
                    // Modify the Publish button to disable it if the assignment is published
                    $action_1 = $row->public_show == 1
                        ? '<span class="btn btn-outline-danger btn-rounded flush-soft-hover disabled" title="Already Published"><i class="fas fa-check text-success"> Published</i></span>'
                        : '<span><a class="btn btn-outline-danger btn-rounded flush-soft-hover publishBtn" data-bs-toggle="tooltip" data-placement="top" title=""
                                data-bs-original-title="Public" href="javascript:void(0)" data-id="' . base64_encode($row->id) . '">
                                <i class="fas fa-check text-success"> Publish</i>
                                </a></span>';
                    $action_5 = '<a href="' . route('questionIndex', urlencode(base64_encode($row->id))) . '" class="btn btn-outline-info" title="Question"><i class="fas fa-question"></i> Questions</a>';

                    // Initialize the action variable
                    $action = '';

                    // Check if the assignment is published
                    if ($row->public_show == 1) {
                        // If published, do not show edit and delete buttons
                        $action .= '<div class="d-flex align-items-center">
                                        <div class="d-flex">
                                            ' . $action_1 . '  <!-- Show disabled Publish button -->
                                            ' . $action_5 . '  <!-- Always show Questions -->
                                        </div>
                                    </div>';
                    } else {
                        // If not published, show all buttons
                        if (Auth::user()->user_type != '0') {
                            $childs = Helper::get_user_permission();
                            $permissions = DB::table('action_masters')->whereIn('id', $childs)->get();

                            foreach ($permissions as $item) {
                                $action .= '<div class="d-flex align-items-center">
                                                ' . (isset($item->action) && $item->action == 'course/edit' ? $action_2 : null) . '  <!-- Edit button if allowed -->
                                                ' . (isset($item->action) && $item->action == 'course-delete' ? $action_3 : null) . '  <!-- Delete button if allowed -->
                                                ' . $action_1 . '  <!-- Show enabled Publish button -->
                                                ' . $action_5 . '  <!-- Always show Questions -->
                                            </div>';
                            }
                        } else {
                            $action .= '<div class="d-flex align-items-center">
                                            <div class="d-flex">
                                                ' . $action_1 . '  <!-- Show enabled Publish button -->
                                                ' . $action_2 . '  <!-- Edit button -->
                                                ' . $action_3 . '  <!-- Delete button -->
                                                ' . $action_5 . '  <!-- Always show Questions -->
                                            </div>
                                        </div>';
                        }
                    }
                    return $action;
                })
                ->addColumn('public_show', function ($data) {
                    if ($data->public_show == 0) {
                        return '<span data-dc="' . base64_encode($data->id) . '" class="badge badge-warning">Pending</span>
                                <span data-ac="' . base64_encode($data->id) . '" class="badge badge-success d-none">Publish</span>';
                    } else {
                        return '<span data-dc="' . base64_encode($data->id) . '" class="badge badge-warning d-none">Pending</span>
                                <span data-ac="' . base64_encode($data->id) . '" class="badge badge-success">Publish</span>';
                    }
                })
                ->editColumn('created_at', function ($user) {
                    return [
                        'display' => e($user->created_at->format('m-d-Y')),
                        'timestamp' => $user->created_at->timestamp
                    ];
                })
                ->rawColumns(['action', 'status', 'public_show'])
                ->make(true);
        }




        return view('admin.Assignment.index');
    }


    public function create(Request $request)
    {
        $ci_id = base64_decode($request->id);

        $sub_moduleId = SubModule::where('id', $ci_id)->first();
        return view('admin.Assignment.create', compact('sub_moduleId'));
    }

    public function assignmentStore(Request $request)
    {

        $rules = [
            'title'        => 'required|regex:/^[a-zA-Z0-9 ]+$/u|min:1|max:255',
            'image'        => 'required|mimes:jpeg,jpg,bmp,png,gif,svg,pdf',
            'description'  => 'required',
            'due_date'     => 'required',
            'due_time'     => 'required',
            'scale_type'   => 'required',
            'total_attempts' => 'required',
            'marks'        => 'required',

        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ]);
        }

        DB::beginTransaction();
        try {

            if ($request->file('image')) {
                $image = $request->file('image');
                $date = date('YmdHis');
                $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                $random_no = substr($no, 0, 2);
                $final_image_name = $date . $random_no . '.' . $image->getClientOriginalExtension();

                $destination_path = public_path('/uploads/assignment/');
                if (!File::exists($destination_path)) {
                    File::makeDirectory($destination_path, $mode = 0777, true, true);
                }
                $image->move($destination_path, $final_image_name);
            }

            $data = [
                'sub_module_id' => $request->input('cours_m_id'),
                'created_by'    => Auth::user()->id,
                'title'     => $request->input('title'),
                'image'     => !empty($final_image_name) ? $final_image_name : NULL,
                'description' => $request->input('description'),
                'due_date' => $request->input('due_date'),
                'due_time' => $request->input('due_time'),
                'scale_type' => $request->input('scale_type'),
                'passing_score' => $request->input('passing_score'),
                'max_score' => $request->input('max_score'),
                'total_attempts' => $request->input('total_attempts'),
                'marks'        => $request->input('marks'),
                'late_submission' => $request->has('late_submission') ? 1 : 0,
                'lock_submission' => $request->has('lock_submission') ? 1 : 0,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];
            // dd($data);
            $assign_id = DB::table('assignments')->insertGetId($data);

            // $assignment = Assignment::find($assign_id);
            // $dueDate = $data['due_date'];
            // $dueTime = $data['due_time'];

            // User::find(Auth::user()->id)->notify(new AssignmentDueDate($dueDate, $dueTime));

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

    public function assignmentEdit(Request $request)
    {
        $assignment_id = base64_decode($request->id);

        $assignment = Assignment::where('id', $assignment_id)->first();

        return view('admin.Assignment.edit', compact('assignment'));
    }

    public function assignmentUpdate(Request $request)
    {

        $rules = [
            'title'       => 'required',
            //'description' => 'required',
            'duration'    => 'required|numeric|min:1',
            'max_score'   => $request->assignment_id != 0 ? 'required|numeric|min:1' : '',
            'pass_score'  => $request->assignment_id != 0 ? 'required|numeric|min:1|lte:max_score' : '',
        ];

        $msgs = [
            'title.required'       => 'The Title is required.',
            //'description.required' => 'The Description is required.',
            'duration.required'    => 'The Duration is required.',
            'duration.numeric'     => 'The Duration must be a numeric value.',
            'duration.min'         => 'The Duration must be at least 1 minute.',
            'max_score.required'   => 'The Maximum Score is required.',
            'max_score.numeric'    => 'The Maximum Score must be a numeric value.',
            'max_score.min'        => 'The Maximum Score must be at least 1.',
            'pass_score.required'  => 'The Passing Score is required.',
            'pass_score.numeric'   => 'The Passing Score must be a numeric value.',
            'pass_score.min'       => 'The Passing Score must be at least 1.',
            'pass_score.lte'       => 'The Passing Score must be less than or equal to the Maximum Score.',
        ];

        $request->validate($rules,$msgs);
        $data = $request->all();
        $id = base64_decode($request->id);
        DB::beginTransaction();
        try {
                $save = Assignment::updateOrCreate([
                    'id' => $id
                ], $data);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return response()->json([
                'success' => false,
                'msg' => 'Error Occurred'
            ]);
        }
        return response()->json([
            'success' => true,
            'msg' => 'Saved Successfully',
            'url' => url('assignment-list'),
        ]);
    }

    public function assignmentDelete(Request $request)
    {
        $a_id = base64_decode($request->id);
        DB::beginTransaction();
        try {
            $blog = Assignment::find($a_id);
            $blog->delete();
            // $blog->save();

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

    public function assignmentPublish(Request $request)
    {
        $a_id = base64_decode($request->id);
        DB::beginTransaction();
        try {
            $blog = Assignment::find($a_id);
            $blog->public_show = '1';
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

    public function assignmentStatus(Request $request)
    {
        $cm_id = base64_decode($request->id);
        //$user = RoleMaster::find($role_id);
        $type = base64_decode($request->type);

        if ($type == 'disable') {
            $user = Assignment::find($cm_id);
            $user->status = '0';
            $user->save();

            return response()->json([
                'success' => true,
                'type' => $type,
                'message' => 'Status change successfully.'
            ]);
        } elseif ($type == 'enable') {
            $user = Assignment::find($cm_id);
            $user->status = '1';
            $user->save();

            return response()->json([
                'success' => true,
                'type' => $type,
                'message' => 'Status change successfully.'
            ]);
        }
    }

    public function assignmentShow(Request $request)
    {
        $assignment_id = base64_decode($request->id);

        $assignments = DB::table("assignments")->where('id', $assignment_id)->first();

        return view('admin.Assignment.show', compact('assignments'));
    }


    public function assignmentIndex($id)
    {
        $id = base64_decode($id);

        $data['subModule'] = SubModule::with('assignments')->find($id);

        foreach($data['subModule']->assignments as $key=>$value ){
            $data['type']=$value->type;
        }
        return view('admin.Assignment.assignments', $data);
    }

    public function assignmentsStore(Request $request, $id)
    {
        // dd($request->all());
        $rules = [
            'data.*.title'       => 'required',
            //'data.*.description' => 'required',
            'data.*.duration'    => 'required|numeric|min:1',
        ];
        $msgs = [
            'data.*.title.required'        => 'The Title is required.',
            //'data.*.description.required'  => 'The Description is required.',
            'data.*.duration.required'     => 'The Duration is required.',
            'data.*.duration.numeric'      => 'The Duration must be a numeric value.',
            'data.*.duration.min'          => 'The Duration must be at least 1 minute.',
        ];

        if($request->type != 0) {
            // $rules['data.*.max_score'] = 'required|numeric|min:1';
            // $rules['data.*.pass_score'] = 'required|numeric|min:1|lte:data.*.max_score';

            $msgs['data.*.max_score.required'] = 'The Maximum Score is required.';
            $msgs['data.*.max_score.numeric']  = 'The Maximum Score must be a numeric value.';
            $msgs['data.*.max_score.min']      = 'The Maximum Score must be at least 1.';
            $msgs['data.*.pass_score.required'] = 'The Passing Score is required.';
            $msgs['data.*.pass_score.numeric']  = 'The Passing Score must be a numeric value.';
            $msgs['data.*.pass_score.min']      = 'The Passing Score must be at least 1.';
            $msgs['data.*.pass_score.lte']      = 'The Passing Score must be less than or equal to the Maximum Score.';
        }

        $request->validate($rules,$msgs);
        $data = $request->all();
        $id = base64_decode($id);
        DB::beginTransaction();
        try {
            foreach ($data['data'] as $key => $value) {
                $value['sub_module_id'] = $id;
                $value['type'] = $request->type;
                $save = Assignment::updateOrCreate([
                    'id' => $key
                ], $value);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return response()->json([
                'success' => false,
                'msg' => 'Error Occurred'
            ]);
        }
        return response()->json([
            'success' => true,
            'msg' => 'Saved Successfully',
            'url' => route('assignment-list')
        ]);
    }
}
