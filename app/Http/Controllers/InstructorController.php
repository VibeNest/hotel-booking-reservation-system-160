<?php

namespace App\Http\Controllers;

class InstructorController extends Controller
{
    // Instructor Dashboard
    public function InstructorDashboard()
    {
        return view('instructor.instructor_dashboard');
    }
}
