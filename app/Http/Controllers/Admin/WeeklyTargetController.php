<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeeklyTarget;
use App\Models\Program;
use Illuminate\Http\Request;

class WeeklyTargetController extends Controller
{
    /**
     * Show all weekly targets
     */
    public function index()
    {
        $targets = WeeklyTarget::with('program')
            ->orderBy('program_id')
            ->orderBy('week_number')
            ->get();

        return view('admin.weekly_targets.index', compact('targets'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $programs = Program::all();

        return view('admin.weekly_targets.create', compact('programs'));
    }

    /**
     * Store weekly target
     */
    public function store(Request $request)
    {
        $request->validate([
            'program_id'  => 'required|exists:programs,id',
            'week_number' => 'required|integer|min:1|max:12',
            'focus_area'  => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        WeeklyTarget::create($request->all());

        return redirect()
            ->route('admin.weekly-targets.index')
            ->with('success', 'Weekly target created successfully.');
    }
    public function destroy($id)
{
    $target = WeeklyTarget::findOrFail($id);
    $target->delete();

    return redirect()->back()->with('success', 'Weekly target deleted successfully.');
}

}
