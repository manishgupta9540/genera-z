<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Helpers\Helper;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PaymentDeatilsController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Payment::with('student','paymentCourses')
                   ->where('order_status', 'Success')
                    ->orderBy('id', 'desc')
                    ->latest()
                    ->get();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('student_name', function($row) {
                        $student = $row->student;
                        return ($student && $student->name && $student->last_name)
                            ? $student->name . ' ' . $student->last_name
                            : 'N/A';
                    })

                    ->addColumn('course_title', function($row) {
                        // Map through each payment course and get the title of the associated course
                        $titles = $row->paymentCourses->map(function($paymentCourse) {
                            return Course::where('id', $paymentCourse->course_id)->pluck('title')->first(); // Retrieve the title directly
                        })->filter()->implode(', '); // Filter out null values and implode into a string
                        return $titles ?: 'N/A'; // Return 'N/A' if no titles are found
                    })

                    ->addColumn('action', function($row){
                        $action_3 = '<span><a class="btn btn-outline-danger btn-rounded flush-soft-hover deleteBtn" data-bs-toggle="tooltip" data-placement="top" title=""
                                    data-bs-original-title="Delete" href="javascript:void(0)" data-id="'.base64_encode($row->id).'">
                                    <i class="fas fa-trash text-danger"></i>
                                    </a></span>';
                        $action =   '<div class="d-flex align-items-center">
                                        <div class="d-flex">
                                        '.$action_3.'
                                        </div>
                                    </div>';
                        return $action;
                    })
                    ->addColumn('order_status', function($row) {
                        return '<span style="color: green;">' . $row->order_status . '</span>';
                    })
                    ->editColumn('created_at', function ($user) {
                        return [
                            'display' => e($user->created_at->format('m-d-Y')),
                            'timestamp' => $user->created_at->timestamp
                        ];
                    })
                    ->rawColumns(['action','student_name','order_status','course_title'])
                    ->make(true);

        }

        return view('admin.payment.index');
    }



}
