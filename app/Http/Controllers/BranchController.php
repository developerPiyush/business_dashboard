<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchWorkingHour;
use App\Models\Business;
use Illuminate\Http\Request;

class BranchController extends Controller
{

    public function index()
    {
        $branches = Branch::all();

        return view('branch.index', compact('branches'));
    }

    public function showTimings($id)
    {
        $branch = Branch::findOrFail($id);
        return view('branch.show_timings', compact('branch'));
    }

    public function getWorkingHours(Request $request, $branchId, $date)
    {
        $branch = Branch::findOrFail($branchId);

        $workingHours = BranchWorkingHour::where('branch_id', $branch->id)
            ->where('date', $date)
            ->get();

        return response()->json($workingHours);
    }



    public function create()
    {
        $businesses = Business::all();
        return view('branch.create', compact('businesses'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'working_hours.*.*.dates.*' => 'nullable|date',
            'working_hours.*.*.start_times.*' => 'nullable|date_format:H:i',
            'working_hours.*.*.end_times.*' => 'nullable|date_format:H:i|after_or_equal:working_hours.*.*.start_times.*',
        ]);

        $branch = Business::findOrFail($request->business_id);
        $newBranch = $branch->branches()->create($validatedData);

        $imagePaths = [];

        foreach ($request->file('images', []) as $image) {
            $path = $image->store('images', 'public');
            $imagePaths[] = $path;
        }
        $newBranch->update(['images' => $imagePaths]);

        if ($request->has('working_hours')) {
            $workingHoursData = $request->input('working_hours');

            foreach ($workingHoursData as $day => $timeSlots) {
                foreach ($timeSlots['start_times'] as $key => $startTime) {
                    $endTime = $timeSlots['end_times'][$key] ?? null;
                    $date = $timeSlots['dates'][$key] ?? null;

                    $newBranch->workingHours()->create([
                        'day' => $day,
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'date' => $date,
                        'closed' => !empty($timeSlots['closed']),
                    ]);
                }
            }
        }

        return redirect()->route('branch.index')->with('success', 'Branch created successfully!');
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return redirect()->route('branch.index')->with('success', 'Branch deleted successfully!');
    }


}










