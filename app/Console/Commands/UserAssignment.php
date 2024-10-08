<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\AssignmentDueDate;
use Illuminate\Support\Facades\Auth;


class UserAssignment extends Command
{
    protected $signature = 'studentassignment:reminder';
  
    protected $description = 'Send assignment reminders to students';

   
    
    public function handle()
    {
        // Fetch courses with successful payments
        // $userIds  = Auth::user()->id;
        $courses = Course::with(['category', 'course_modules.sub_modules.assignments'])
                        ->join('payments as p', 'p.course_id', '=', 'courses.id')
                        ->where('p.status', 'success')
                        ->orderBy('courses.id', 'desc')
                        ->select('courses.*')
                        ->get();

        foreach ($courses as $course) 
        {
            foreach ($course->course_modules as $module) 
            {
                foreach ($module->sub_modules as $subModule) {
                    foreach ($subModule->assignments as $assignment) {
                        // Check if assignment is due tomorrow
                        $assignmentTitle = $assignment->title;
                        // dd($assignmentTitle);
                        $dueDate = $assignment->due_date;
                      
                        $previousDate = Carbon::parse($dueDate)->subDay()->format('Y-m-d');
                       
                        if ($previousDate) {
                            // Notify the students about the assignment due date
                            $studentIds = Payment::where('status', 'success')
                                            ->where('course_id', $course->id)
                                            ->pluck('user_id');

                            foreach ($studentIds as $studentId) {
                                $student = User::find($studentId);
                                if ($student) {
                                    $student->notify(new AssignmentDueDate($assignment->due_date,$assignmentTitle));
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->info('Assignment reminders sent successfully.');

        return 0;
    }
    
    
}
