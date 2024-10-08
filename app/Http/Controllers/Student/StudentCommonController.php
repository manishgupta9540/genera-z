<?php

namespace App\Http\Controllers\Student;

use PDF;
use Mail;
use App\Models\User;
use App\Models\Course;
use App\Models\Result;
use App\Models\Payment;
use App\Models\Countrie;
use App\Models\Material;
use App\Models\SubModule;
use App\Models\Assignment;
use App\Models\UserCourse;
use App\Models\UserMaterial;
use Illuminate\Http\Request;
use App\Models\khdaCertificate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Validator;


class StudentCommonController extends Controller
{
    public function index()
    {
        $students = User::with('country')->where('id', Auth::user()->id)->first();
        $users = User::where('user_type', '0')->first();
        $khdaCerficate=khdaCertificate::where('student_id',Auth::user()->id)->first();
        return view('student.index', compact('students', 'users','khdaCerficate'));
    }

    public function accomplishments()
    {
        $auth    = Auth::user();
        $users   = User::where('user_type', '0')->first();
        $courses = $auth->courses;
        $assignments = $auth->userAssignments;
        return view('student.pages.accomplishments', compact('courses', 'assignments', 'users'));
    }

    public function generate_certificate(Request $request)
    {
        if($request->get('course_id'))
        {
            $studentId = Auth::user()->id;
            $course_id = base64_decode($request->get('course_id'));
            $course_info = DB::table('user_courses')->where(['user_id'=>$studentId,'course_id'=>$course_id])->first();

            $data['course']      = Course::where('id',$course_info->course_id)->first();
            $data['course_info'] = $course_info;
            $data['first_name']  = Auth::user()->name;
            $data['last_name']   = Auth::user()->last_name;

            $pdf = PDF::loadView('student.pages.certificate_pdf', $data)->setPaper('a4', 'landscape');

            if($request->get('type')=='download')
            {
                return $pdf->download('certificate_'.$course_id.'.pdf');
            }
            else
            {
                return $pdf->stream('certificate_'.$course_id.'.pdf');
            }
        }
        else
        {
            abort('404');
        }
    }


    public function myLearning()
    {
        $auth = Auth::user();

        $userCourses = $auth->userCourses;
        $users = User::where('user_type', '0')->first();
        return view('student.pages.my-learning', compact('userCourses', 'users'));
    }

    public function storeRating(Request $request){
        $request->validate([
            'review'=>'required'
        ]);
        try {

           $rating = UserCourse::where('id',$request->id)->update(
            [
                'review'        =>$request->review,
                'review_date' => now(),
            ]);

           if( $rating ==true){
                return response()->json(['success'=>true,'msg'=>'Rating submitted successfully done']);
           }else{
            return response()->json(['success'=>false,'msg'=>'Rating  not submitted ']);
           }
        } catch (\Throwable $th) {
            return response()->json(['success'=>false,'msg'=>'Rating  not submitted ']);
        }
    }
    public function markCourseAsCompleted(Request $request)
    {
        $userId = $request->input('user_id');
        $courseId = $request->input('course_id');
        // dd($courseId);

        DB::table('user_courses')->where([
            'user_id' => $userId,
            'course_id' => $courseId,
        ])->update([
            'completed' => 1,
            'complet_date' => now(),
        ]);

        return response()->json([
            'success' => true
        ]);
    }


    public function courseDetails(Request $request)
    {
        $id = base64_decode($request->id);
        // dd($id);
        $course = Course::with('category', 'modules')->find($id);
        // dd($course);
        $tabs = $course->modules->where('status', 1)->values();
        // dd($tabs);
        $users = User::where('user_type', '0')->first();
        $auth =Auth::user()->id;
        $userCourses =UserMaterial::where('user_id', $auth)->select('material_id','user_id')->get();
        return view('student.pages.course-details', compact('course', 'users', 'tabs','userCourses'));
    }

    public function showPpt($id)
    {
        $decodedId = base64_decode(urldecode($id));
        $material = Material::find($decodedId);
        $auth =Auth::user()->id;
        $userCourses =UserMaterial::where('user_id', $auth)->select('material_id','user_id')->get();
        // dd($userCourses);
        $pptUrl = asset('uploads/PPT/' . $material->ppt);
        return view('student.pages.ppt', compact('pptUrl','material','auth','userCourses'));
    }


    public function moduleFilter(Request $request)
    {
        $id = $request->id;

        $subModules = SubModule::with('materials', 'assignments')
                                ->where('module_id', $id)
                                ->get();
        $users = User::where('user_type', '0')->first();
        return view('student.pages.module_filter', compact('subModules', 'users'));
    }

    public function courseMaterial(Request $request)
    {
        $id = base64_decode($request->id);

        $courseMaterial = Material::where('id', $id)->first();

        $users = User::where('user_type', '0')->first();
        return view('student.pages.course-material', compact('courseMaterial', 'users'));
    }

    public function courseMaterialTitle(Request $request)
    {
        $id = base64_decode($request->id);
        $courseData = DB::table('materials')->where('id', $id)->first();

        return view('student.pages.course-title', compact('courseData'));
    }

    public function courseMaterialQuize(Request $request)
    {
        $id = base64_decode($request->id);
        $assignData = DB::table('assignments')->where('id', $id)->first();
        $users = User::where('user_type', '0')->first();

        return view('student.pages.course-assignment', compact('assignData', 'users'));
    }

    public function courseQuize(Request $request)
    {
        $id = base64_decode($request->id);
        $assignData = Assignment::where('id', $id)->first();
        $user = Auth::user();
        $attemptCount = DB::table('quiz_attempts')
            ->where('student_id', $user->id)
            ->where('quiz_id', $assignData->id)
            ->count();
        $canAttempt = $attemptCount == $assignData->total_attempts;

        $quezeQuestions = DB::table('queiz_questions')->where('question_type', 'multiple_choice')->where('assign_id', $id)->get();
        $shortQuestions = DB::table('queiz_questions')->where('question_type', 'short_answer')->where('assign_id', $id)->get();
        $users = User::where('user_type', '0')->first();

        return view('student.pages.course-quize', compact('quezeQuestions', 'assignData', 'shortQuestions', 'canAttempt', 'users'));
    }

    public function studentAssignmentsSave(Request $request)
    {
        $data           = $request->all();
        $student_id     = Auth::user()->id;
        $assignment_id  = $request->assignment_id;
        $quiz_id        = $request->input('quiz_id');  // Ensure correct retrieval of quiz_id
        $date           = date('Y-m-d H:i:s');

        $assignment = Assignment::find($assignment_id);

        $course_id = $assignment->sub_module->module->course_id;

        if (isset($data['questions'])) {
            foreach ($data['questions'] as $question) {
                $selected_option = $question['selected_option'] ?? null;

                $question_id = $question['q_id'];

                $optionsString = DB::table('queiz_questions')->where('id', $question_id)->value('option');
                $optionsArray = explode(',', $optionsString);

                // Generate labels dynamically based on the number of options
                $labels = range('A', 'F');

                if (count($optionsArray) > count($labels)) {
                    $additionalLabels = array_map(function ($num) {
                        return 'Label' . $num;
                    }, range(1, count($optionsArray) - count($labels)));
                    $labels = array_merge($labels, $additionalLabels);
                }
                $labeledOptions = array_combine(array_slice($labels, 0, count($optionsArray)), $optionsArray);
                $teacherAnswer = DB::table('queiz_questions')->where('id', $question_id)->value('answer');

                $isCorrect = $teacherAnswer == $selected_option;


                Result::create([
                    'quiz_id'       => $assignment_id,
                    'student_id'    => $student_id,
                    'question_id'   => $question_id,
                    'course_id'     => $course_id,
                    'result'        => $isCorrect,
                    'submit_answer' => $selected_option,
                    'date'          => $date,

                ]);
            }
        }

        if (isset($data['short_questions'])) {
            foreach ($data['short_questions'] as $shortQuestion) {
                Result::create([
                    'quiz_id' => $assignment_id,
                    'student_id' => $student_id,
                    'question_id' => $shortQuestion['answers'],
                    'result' => 0, // Assuming you evaluate short answers manually
                    'submit_answer' => $shortQuestion['answer'] ?? '',
                    'course_id' => $course_id,
                    'date' => $date
                ]);
            }
        }


        $quiz_attempt = [
            'quiz_id' => $assignment_id,
            'student_id' => $student_id,
            'course_id' => $course_id,
            'created_at' => $date,  // Use the formatted date
            'updated_at' => $date,
        ];
        DB::table('quiz_attempts')->insert($quiz_attempt);

        $data['total_question'] = Result::where('quiz_id', $assignment_id)->where('student_id', $student_id)->count();
        $data['accurate_answer'] = Result::where(['result' => true, 'quiz_id' => $assignment_id])->where('student_id', $student_id)->count();
        $course_info = DB::table('quizzes')->where('id', $assignment_id)->first();
        $id = base64_encode($request->assignment_id);
        return redirect()->route('preview', $id);
    }

    public function courseMaterialAttempt(Request $request)
    {
        $course_mat_id = $request->cm_id;
    }

    public function quize_preview($id)
    {
        $id = base64_decode($id);

        $data['total_question']  = Result::where('quiz_id', $id)->count();
        $data['accurate_answer'] = Result::where(['result' => true, 'quiz_id' => $id])->count();

        return view('student.pages.quize_preview')->with($data);
    }

    public function grades(Request $request, $id)
    {
        $id = base64_decode($id);
        $auth = Auth::user();
        $users = User::where('user_type', '0')->first();
        $course = Course::find($id);
        $assignments = $auth->userAssignments;

        return view('student.pages.grades', compact('assignments', 'course', 'users'));
    }

    public function myPurchase()
    {
        $payments = Payment::where(['user_id'=>Auth::user()->id,'success'=>'1','order_status'=>'Success'])->orderBy('id', 'desc')->get();
        $users = User::where('user_type', '0')->first();
        return view('student.pages.my-purchase', compact('payments', 'users'));
    }



    public function editProfile()
    {
        $students = User::where('id', Auth::user()->id)->first();
        $states = DB::table('states')->get();
        $countries = DB::table('countries')->get();
        $users = User::where('user_type', '0')->first();
        return view('student.pages.edit-profile', compact('students', 'states', 'countries', 'users'));
    }

    public function profileSave(Request $request)
    {
        $id = $request->id;

        $rules = [
            'name'          => 'required|regex:/^[a-zA-Z ]+$/u|min:1|max:255',
            'last_name'     => 'required|regex:/^[a-zA-Z ]+$/u|min:1|max:255',
            'email'         => 'required|email:rfc,dns',
            'phone_number' => 'nullable|digits:10|numeric',
            // 'address'      => 'required',
            // 'city'         => 'required',
            // 'image'        => 'nullable|mimes:jpeg,jpg,bmp,png,gif,svg',
            // 'states_id'    =>  'required',
            // 'zip_code'     =>  'required',
            // 'country_id'    => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
        $old_image = DB::table('users')->where('id', $id)->first();

        DB::beginTransaction();
        try {

            if ($request->file('image')) {
                $image = $request->file('image');
                $date = date('YmdHis');
                $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                $random_no = substr($no, 0, 2);
                $final_image_name = $date . $random_no . '.' . $image->getClientOriginalExtension();

                $destination_path = public_path('/uploads/studentProfile/');
                if (!File::exists($destination_path)) {
                    File::makeDirectory($destination_path, $mode = 0777, true, true);
                }
                $image->move($destination_path, $final_image_name);
            } else {
                $final_image_name = $old_image->image;
            }

            $user_data =
                [
                    'name'          => $request->name,
                    'last_name'     => $request->last_name,
                    'email'         => $request->email,
                    'phone_number'  => $request->phone_number,
                    'address'       => $request->address,
                    'image'         => !empty($final_image_name) ? $final_image_name : NULL,
                    'city'          => $request->city,
                    'states_id'     => $request->states_id,
                    'zip_code'      => $request->zip_code,
                    'country_id'      => $request->country_id,
                    'updated_at'    => date('Y-m-d H:i:s')
                ];
            // dd($user_data);
            $user = DB::table('users')->where('id', $id)->update($user_data);

            DB::commit();

            return response()->json([
                'success' => true,
                'custom'  => 'yes',
                'msg'     => 'Profile Updated Successfully',
                'url'     => route('student.dashboard'),  // Directly passing the route URL
                'errors'  => []
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }


    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:8|current_password',
            'password' => 'required|min:8|same:confirm_password',
            'confirm_password' => 'required|min:8|same:password',
        ], [
            'old_password.required' => 'The old password is required.',
            'old_password.min' => 'The old password must be at least 8 characters long.',
            'old_password.current_password' => 'The old password is incorrect.',

            'password.required' => 'The new password is required.',
            'password.min' => 'The new password must be at least 8 characters long.',
            'password.same' => 'The new password and confirmation password do not match.',

            'confirm_password.required' => 'The confirmation password is required.',
            'confirm_password.min' => 'The confirmation password must be at least 8 characters long.',
            'confirm_password.same' => 'The confirmation password does not match the new password.',
        ]);

        $data = $request->all();

        $auth = Auth::user();
        $auth->password = bcrypt($data['password']);
        $auth->save();

        return response()->json([
            'success' => true,
            'msg' => 'Password changed successfully.'
        ]);
    }
}
