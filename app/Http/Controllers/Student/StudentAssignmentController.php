<?php

namespace App\Http\Controllers\Student;

use App\Models\UserAssignment;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShortAnswer;

class StudentAssignmentController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function assignmentDta($id)
    {
        $id = base64_decode($id);
        $data['assignData'] = Assignment::find($id);
        $data['users'] = User::where('user_type', '0')->first();
        $query = UserAssignment::where(['user_id'=>Auth::user()->id, 'assignment_id'=> $id]);
        $shortAnswer = ShortAnswer::where(['user_id'=>Auth::user()->id, 'assignment_id'=> $id])->latest()->first();
        $data['shortStatus']=$shortAnswer->status ?? '';
        $data['count']= $query->count();
        $data['userAssign'] =$query->where('completed',1)->latest()->first();
        $data['passingScore'] =$data['assignData']->pass_score;
        return view('student.pages.course-assignment')->with($data);
    }

    public function show($id)
    {

        $authUser = Auth::user()->id;
        $id = base64_decode($id);
        $assignment = Assignment::find($id);
        $data=[];
        $userAssign =UserAssignment::where(['user_id'=>$authUser,'assignment_id'=>$assignment->id])->count();
        $checkCountAssgiment =$assignment->attempts;
        if ($userAssign==$checkCountAssgiment) {
            return redirect()->back()->with('msg', 'Attempts for this assignment exceeded');
        }
        return view('student.pages.assignment',compact('assignment'));
    }


    public function submit(Request $request, $id)
    {
        $data = $request->all();
        $assignmentId = $request->assigmnet_id;

        $id = base64_decode($id);

        $userAssignment = UserAssignment::find(base64_decode(urldecode($data['uaid'])));
        $userAssignment->end_time = Carbon::now();

        $correctAns = 0;
        $assignment = Assignment::find($id);
        $total = $assignment->max_score;

        $questionIds    = $data['question_id'];
        //$assignmentId   = $data['assigmnet_id'];
        $answers        = $data['answer']  ?? [];
        $data=[];
        if($request->type == 0){
            foreach ($questionIds as $index => $questionId) {
                $data[$questionId]=$answers[$index];
            }
            $userAnswer = new ShortAnswer();
            $userAnswer->user_id = Auth::user()->id;
            $userAnswer->assignment_id = $assignmentId;
            $userAnswer->question_id = json_encode($questionIds);
            $userAnswer->answer = json_encode($data);
            $userAnswer->status = '0';
            $userAnswer->save();
        }
        else
        {
            $data = $request->input('check', []);
            if (!empty($data))
            {
                $data =$request['check'];
                    foreach ($data as $key => $value) {
                        $question = Question::find($key);
                        if ($question && $question->answer->option_id == base64_decode($value)) {
                            $correctAns++;
                        }
                    }
                    $score = ($correctAns / $assignment->questions->count()) * 100;
                    $userAssignment->score = $score;

                    $passScore = ($assignment->pass_score / $assignment->max_score) * 100;
                    if ($score >= $passScore) {
                        $userAssignment->completed = true;
                    }
                $userAssignment->save();
            }
            else {
                $assignData = Assignment::find($id);
                $users = User::where('user_type', '0')->first();
                $query = UserAssignment::where(['user_id' => Auth::user()->id, 'assignment_id' => $id]);
                $count = $query->count();
                $userAssign = $query->where('completed', 1)->latest()->first();
                $passingScore = $assignData->pass_score;

                return redirect()->route('student.assignment-data', ['id'=>base64_encode($assignmentId)])->with('error', 'No answers selected.');

            }
        }
        $assignData = Assignment::find($id);
        $users = User::where('user_type', '0')->first();
        $query = UserAssignment::where(['user_id' => Auth::user()->id, 'assignment_id' => $id]);
        $count = $query->count();
        $userAssign = $query->where('completed', 1)->latest()->first();
        $passingScore = $assignData->pass_score;

        return redirect()->route('student.assignment-data', ['id'=>base64_encode($assignmentId)])->with('error', 'No answers selected.');
    }



    public function start(Request $request,$id)
    {
        $id = base64_decode($id);
        $assignment = Assignment::find($id);
        $userAssignment = UserAssignment::create([
            'assignment_id' => $assignment->id,
            'user_id' => Auth::user()->id,
            'start_time' => date('Y-m-d H:i:s'),
        ]);
        $uaid = $userAssignment->id;
        return response()->json([
            'success' => true,
            'time' => $assignment->duration,
            'parent' => '#addParent_'.config('addPages.assignmentTest.id'),
            'html' => view('student.components.assignmentTest',compact('assignment','uaid'))->render()
        ]);
    }
}
