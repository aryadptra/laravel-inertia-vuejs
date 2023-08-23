<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Exam;
use App\Models\ExamSession;
use Illuminate\Http\Request;
use App\Models\Student;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // count students
        $students = Student::count();

        // count exams
        $exams = Exam::count();

        // count exam sessions
        $exam_sessions = ExamSession::count();

        // classrooms
        $classrooms = Classroom::count();

        return Inertia::render('Admin/Dashboard/Index', [
            'students' => $students,
            'exams' => $exams,
            'exam_sessions' => $exam_sessions,
            'classrooms' => $classrooms,
        ]);
    }
}