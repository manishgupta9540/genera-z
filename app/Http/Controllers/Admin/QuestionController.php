<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\QueizQuestion;
use App\Models\Quiz;
use App\Models\SubModule;
use App\Models\Assignment;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use App\Models\Answer;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Question::with('assignment')->select('id', 'assignment_id', 'content', 'created_at')
                ->orderBy('id', 'desc')
                ->latest()->get();

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $edit_url = url('/question-quize', ['id' => base64_encode($row->id)]);

                    $action_2 = '<a href="' . $edit_url . '" class="btn btn-outline-info" title="Edit"><i class="fas fa-edit text-info"></i></a>';

                    $action_3 = '<span><a class="btn btn-outline-danger btn-rounded flush-soft-hover deleteBtn" data-bs-toggle="tooltip" data-placement="top" title=""
                            data-bs-original-title="Delete" href="javascript:void(0)" data-id="' . base64_encode($row->id) . '">
                            <i class="fas fa-trash text-danger"></i>
                            </a></span>';

                    $action =   '<div class="d-flex align-items-center">
                                <div class="d-flex">
                                ' . $action_2 . '
                                ' . $action_3 . '
                                </div>
                            </div>';

                    $action = '';
                    if (Auth::user()->user_type != '0') {
                        $childs = Helper::get_user_permission();
                        $permissions = DB::table('action_masters')->whereIn('id', $childs)->get();
                        // dd($permissions);
                        foreach ($permissions as $item) {
                            $action .= '<div class="d-flex align-items-center">
                                                ' . (isset($item->action) && $item->action == 'course/edit' ? $action_2 : null) . '
                                                ' . (isset($item->action) && $item->action == 'course-delete' ? $action_3 : null) . '

                                        </div>';
                        }
                    } else {
                        $action = '<div class="d-flex align-items-center">
                                        <div class="d-flex">
                                            ' . $action_2 . '
                                            ' . $action_3 . '
                                        </div>
                                    </div>';
                    }
                    return $action;
                })
                ->editColumn('content', function ($model) {
                    return strip_tags($model->content);
                })
                ->addColumn('assignemt_name', function ($model) {
                    return $model->assignment->title ?? '';
                })
                ->editColumn('created_at', function ($user) {
                    return [
                        'display' => e($user->created_at->format('m-d-Y')),
                        'timestamp' => $user->created_at->timestamp
                    ];
                })
                ->editColumn('image', function ($data) {
                    $url = url("uploads/blogs/" . $data->image);
                    return '<img src="' . $url . '" style="width:100px; height:100px;"/>';
                })

                ->rawColumns(['action', 'status', 'image', 'content','assignemt_name'])
                ->make(true);
        }

        return view('admin.question.index');
    }

    public function create(Request $request)
    {
        $qiue_id = base64_decode($request->id);
        //    dd($qiue_id);
        $assignData = Assignment::where('id', $qiue_id)->first();
        // dd($assignData);

        return view('admin.question.create', compact('assignData'));
    }

    public function questionQuizeSave(Request $request)
    {
        $assign_id = base64_decode($request->assign_id);
        // dd($quize_id);
        $rules = [
            // 'mark' => 'required',
            // 'course' => 'required',
            // 'title' => 'required',
            // 'description' => 'required',
            // 'time_limits' => 'required',
            // 'negative_mark' => 'required',
            // 'instant_feedback' => 'required_without_all:re_attempt,hide_results',
            // 're_attempt' => 'required_without_all:instant_feedback,hide_results',
            // 'hide_results' => 'required_without_all:instant_feedback,re_attempt',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
        DB::beginTransaction();
        try {
            $question_types1 = $request->input('question_type');
            $questions1 = $request->input('question1');
            $options1 = $request->input('option1');
            $answers1 = $request->input('answer1');

            $questions4 = $request->input('question4');
            $options4 = $request->input('option4');
            $question_types4 = $request->input('question_type');
            $answers4 = $request->input('answer4');

            if ($question_types1 == 'multiple_choice') {
                $data1 = [];
                // dd($request->all());
                for ($i = 0; $i < count($questions1); $i++) {
                    $ky = $request->input('question_id1')[$i];
                    $data1[] = [
                        'assign_id' => $assign_id,
                        'question_type' => $question_types1,
                        'question' => $questions1[$i],
                        'option' => implode(',', $options1[$ky]), // Get the options for the specific question
                        'answer' => $answers1[$i],
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
                DB::table('queiz_questions')->insert($data1);
            } else {
                $data4 = [];
                for ($i = 0; $i < count($questions4); $i++) {
                    $data4[] = [
                        'assign_id' => $assign_id,
                        'question_type' => $question_types4, // Index the question type array
                        'question' => $questions4[$i],
                        'answer' => $answers4[$i],
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                }
                DB::table('queiz_questions')->insert($data4);
            }

            DB::commit();
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function questionEdit(Request $request)
    {
        $qId = base64_decode($request->id);
        // dd($qId);
        $question = Question::where('id', $qId)->first();
        // dd($question);

        return view('admin.question.edit', compact('question'));
    }

    public function questionUpdate(Request $request)
    {
        // dd($request->all());
        $type = $request->type;
        if ($type == '0') {
            $request->validate([
                'content' => 'required',
                'image' => 'sometimes|mimes:png,jpg'
            ], [
                'content.required' => 'Content is required.',
                'image.mimes' => 'Supported format: png, jpg.'
            ]);
        } else {
            $request->validate([
                'content' => 'required',
                'image' => 'sometimes|mimes:png,jpg',
                'answer' => 'required',
                'options' => 'required|array|min:2',
                'options.*.content' => 'required|string',
            ], [
                'content.required' => 'Content is required.',
                'options.min' => 'Add at least two options.',
                'options.required' => 'Add at least two options.',
                'options.array' => 'Options must be an array.',
                'answer.required' => 'Select an option as the answer.',
                'image.mimes' => 'Supported format: png, jpg.',
                'options.*.content.required' => 'Each option content is required.',
            ]);
        }

        $data = $request->all();
        $question_id= ($data['question_id']);
        $assignment_id = ($data['assignment_id']);
        // dd($id);
        // dd($data['assignment_id']);
        DB::beginTransaction();
        try {
                if (isset($data['image'])) {
                    $image = $data['image'];
                    $name = hrtime(true) . '.' . $image->getClientOriginalExtension();
                    $path = public_path('/uploads/questionImages/');
                    if (!File::exists($path)) {
                        File::makeDirectory($path, 0777, true, true);
                    }
                    $image->move($path, $name);
                    $data['image'] = $name;
                } else {
                    unset($data['image']);
                }
                // dd($id);

                $saveQues = Question::updateOrCreate([
                    'id' => $question_id,
                    'type' => $type
                ], $data);
                if($type=='1'){
                    foreach ($data['options'] as $optionKey => $option) {
                        $option['assignment_id'] = $assignment_id;
                        $option['question_id'] = $saveQues->id;
                        $option = Option::updateOrCreate([
                            'id' => $optionKey
                        ], $option);
                        if ($data['answer'] == $optionKey) {
                            Answer::updateOrCreate([
                                'question_id' => $saveQues->id
                            ], [
                                'question_id' => $saveQues->id,
                                'option_id' => $option->id
                            ]);
                        }
                    }

                }
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Saved Successfully',
                'url' =>  url('question-list'),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return response()->json([
                'success' => false,
                'msg' => 'Error Occurred'
            ]);
        }

    }

    public function questionDelete(Request $request)
    {

        $q_id = base64_decode($request->id);

        DB::beginTransaction();
        try {
            $blog = Question::find($q_id);
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

    public function questionStatus(Request $request)
    {
        $qz_id = base64_decode($request->id);
        //$user = RoleMaster::find($role_id);
        $type = base64_decode($request->type);

        if ($type == 'disable') {
            $user = QueizQuestion::find($qz_id);
            $user->status = '0';
            $user->save();

            return response()->json([
                'success' => true,
                'type' => $type,
                'message' => 'Status change successfully.'
            ]);
        } elseif ($type == 'enable') {
            $user = QueizQuestion::find($qz_id);
            $user->status = '1';
            $user->save();

            return response()->json([
                'success' => true,
                'type' => $type,
                'message' => 'Status change successfully.'
            ]);
        }
    }


    public function questionIndex(Request $request, $id)
    {

        $id = base64_decode($id);
        $data['assignment'] = Assignment::with('questions')->find($id);
        foreach($data['assignment']->questions as $key=>$value ){
            $data['type']=$value->type;
        }
        return view('admin.question.questions', $data);
    }


    public function questionStore(Request $request, $id)
    {
        // dd($request->all());
        $type = $request->type;
        if ($type == '0') {
            $rules['data.*.content'] = 'required';
            $rules['data.*.image'] = 'sometimes|mimes:png,jpg,jpeg'; // Corrected MIME types
        } else {
            $rules = [
                'data' => 'required|array|min:1',
                'data.*.options' => 'required|array|min:2',
                'data.*.options.*.content' => 'required|string',
                'data.*.answer' => 'required'
            ];
        }

        $request->validate($rules, [
            'data' => 'Add at least one question.',
            'data.*.content.required' => 'Content is required.',
            'data.*.options.min' => 'Add at least two options.',
            'data.*.options.required' => 'Add at least two options.',
            'data.*.options.array' => 'Add at least two options.',
            'data.*.answer.required' => 'Select an option as answer.',
            'data.*.image.mimes' => 'Supported formats: png, jpg, jpeg.', // Corrected error message
            'data.*.options.*.content' => 'Option content is required.'
        ]);


        $data = $request->all();
        $id = base64_decode($id);
        // dd($request->all());
        DB::beginTransaction();
        try {
            if ($type == '1') {
                foreach ($data['data'] as $quesKey => $question) {
                    if (isset($question['image'])) {
                        $image = $question['image'];
                        $name = hrtime(true) . '.' . $image->getClientOriginalExtension();
                        $path = public_path('/uploads/questionImages/');
                        if (!File::exists($path)) {
                            File::makeDirectory($path, 0777, true, true);
                        }
                        $image->move($path, $name);
                        $question['image'] = $name;
                    } else {
                        unset($question['image']);
                    }
                    $question['assignment_id'] = $id;
                    $question['type'] = $type;


                    $saveQues = Question::updateOrCreate(['id' => $quesKey], $question);

                    foreach ($question['options'] as $optionKey => $option) {
                        $option['assignment_id'] = $id;
                        $option['question_id'] = $saveQues->id;
                        $option = Option::updateOrCreate(['id' => $optionKey], $option);

                        if ($question['answer'] == $optionKey) {
                            Answer::updateOrCreate(['question_id' => $saveQues->id], [
                                'question_id' => $saveQues->id,
                                'option_id' => $option->id
                            ]);
                        }
                    }
                }
            } else {
                foreach ($data['data'] as $quesKey => $question) {
                    if (isset($question['image'])) {
                        $image = $question['image'];
                        $name = hrtime(true) . '.' . $image->getClientOriginalExtension();
                        $path = public_path('/uploads/questionImages/');
                        if (!File::exists($path)) {
                            File::makeDirectory($path, 0777, true, true);
                        }
                        $image->move($path, $name);
                        $question['image'] = $name;
                        $question['type'] = $type;

                    } else {
                        unset($question['image']);
                    }
                    $question['assignment_id'] = $id;
                    $question['type'] = $type;
                    $saveQues = Question::updateOrCreate(['id' => $quesKey], $question);
                }
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'msg' => 'Saved Successfully',
                'url' => url('question-list'),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return response()->json([
                'success' => false,
                'msg' => 'Error Occurred'
            ]);
        }


    }

}
