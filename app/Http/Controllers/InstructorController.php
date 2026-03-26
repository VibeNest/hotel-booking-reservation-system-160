<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstructorController extends Controller
{
    // Instructor Dashboard
    public function InstructorDashboard()
    {
        return view('instructor.instructor_dashboard');
    }
}
