<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Question;
use App\Models\ShortAnswer;
use Illuminate\Http\Request;
use App\Models\khdaCertificate;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
class ShortAnswerController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $shortAnswers = ShortAnswer::with('user', 'assignment')
                            ->orderBy('id', 'desc')
                            ->latest()->get();
            return DataTables::of($shortAnswers)
                ->addIndexColumn()
                ->editColumn('created_at', function ($shortAnswer) {
                    return Carbon::parse($shortAnswer->created_at)->format('d-M-Y');
                })
                ->addColumn('user_name', function($row) {
                    return $row->user->name ?? 'N/A';
                })
                ->addColumn('assignment_name', function($row) {
                    return $row->assignment->title ?? 'N/A';
                })
                ->addColumn('action', function($row){
                    $editUrl = '<a href="' . route('short-answer', \base64_encode($row->id)) . '" title="Show question"  class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>';
                    return $editUrl;
                })

                ->addColumn('status', function($row){
                    if ($row->status == 0) {
                        return '<span class="badge bg-warning text-dark">Process</span>';
                    } else if($row->status == 1) {
                        return '<span class="badge bg-success text-light">Pass</span>';
                    }else{
                        return '<span class="badge bg-danger text-light">Fail</span>';
                    }
                })
                ->rawColumns(['action','status','created_at','user_name','assignment_name'])
                ->make(true);

            }
            return view('admin.short_answer.index');
    }
    public function showAnswerAndQuestion($id){
    $shortId =base64_decode($id);
    $getAnswer =ShortAnswer::where('id', $shortId)->latest()->first();
    $questionAnswer = json_decode($getAnswer->answer, true);
      $answers = [];
        $data['assignamet_name']= $getAnswer->assignment->title;
        $data['short_id']= $getAnswer->id;
        $data['status']= $getAnswer->status;
        foreach ($questionAnswer as $key => $value) {
            $question = Question::find($key);
            if ($question) {
                $data['answers'][] = [
                    'question' => $question->content,
                    'image' => $question->image,
                    'answer'   => $value,
                ];
            }
        }
        return view('admin.short_answer.short-answer-review')->with($data);

    }
    public function answerSubmit(Request $request){
        try {
            $shortId =$request->short_id;
            $result =$request->check;
            $getAnswer =ShortAnswer::where('id',  $shortId)->update(['status'=>$result]);
            return response()->json(['success'=>true,'msg'=>'Submission completed successfully','url'=>route('short-list')]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>false,'error'=>'Submission not  completed successfully']);

        }
    }
}
