<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\UserCourse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
class ReviewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $reviews = UserCourse::with('user', 'course')->where('completed',1)
            ->whereNotNull('review')->latest()->get();
            return DataTables::of($reviews) // Changed from $certificates to $reviews
                ->addIndexColumn()
                ->editColumn('review_date', function ($review) {
                    return Carbon::parse($review->review_date)->format('d-M-Y');
                })
                ->addColumn('user_name', function ($review) {
                    return $review->user->name . ' ' . $review->user->last_name;
                })
                ->addColumn('course_title', function ($review) {
                    return $review->course->title;
                })
                ->addColumn('review', function($row) {
                    $reviewText = Str::limit($row->review, 50);
                    $addBtn = '<a href="javascript:void(0)" class="no-underline" onclick="getReviewData('.$row->id.')" data-id='.$row->id.' data-bs-toggle="modal" data-bs-target="#exampleModal">' . $reviewText . '</a>';
                    return $addBtn;
                })

                ->rawColumns(['review','user_name','course_title'])
                ->make(true);
        }

        return view('admin.review.index');
    }
    public function getReview(Request $request){
        $reviews = UserCourse::where('id',$request->id)->latest()->first();
        return response()->json(['success'=>true,'data'=>$reviews]);
    }

}
