<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\WeeklyProgress;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Achievement;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Example: get some summary stats
        $totalStudents = Enrollment::count();
        $activeEnrollments = Enrollment::where('status', 'active')->count();
        $totalPayments = Payment::sum('amount_paid');

        // Example: get recent weekly progress submissions
        $recentProgress = WeeklyProgress::latest()->take(5)->get();

        // Example: recent attendance records
        $recentAttendance = Attendance::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'activeEnrollments',
            'totalPayments',
            'recentProgress',
            'recentAttendance'
        ));
    }
    public function store(Request $request)
{
    Enrollment::create($request->only(['user_id','program_id','start_date','status']));
    return redirect()->route('admin.dashboard')->with('success','Student enrolled successfully');
}

}
