<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ClassSchedule;
use App\Http\Requests\ClassRoom\StoreClassScheduleRequest;
use Illuminate\Http\Request;

class ClassScheduleController extends Controller
{
    public function index(ClassModel $class)
    {
        $class->load(['schedules', 'course', 'level', 'teacher', 'room.building']);
        return view('admin.class_schedules.index', compact('class'));
    }

    public function store(StoreClassScheduleRequest $request, ClassModel $class)
    {
        $validated = $request->validate([
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Check for time conflicts
        $exists = ClassSchedule::where('class_id', $class->id)
            ->where('day_of_week', $validated['day_of_week'])
            ->where(function ($q) use ($validated) {
                $q->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                  ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                  ->orWhere(function ($q2) use ($validated) {
                      $q2->where('start_time', '<=', $validated['start_time'])
                         ->where('end_time', '>=', $validated['end_time']);
                  });
            })
            ->exists();

        if ($exists) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Schedule conflicts with existing schedule.'], 422);
            }
            flash()->error('Schedule conflicts with existing schedule.');
            return back()->withInput();
        }

        $schedule = ClassSchedule::create([
            'class_id' => $class->id,
            ...$validated,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Schedule added successfully.', 'schedule' => $schedule]);
        }

        flash()->success('Schedule added successfully.');
        return redirect()->route('classes.schedules.index', $class);
    }

    public function destroy(ClassModel $class, ClassSchedule $schedule)
    {
        $schedule->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['message' => 'Schedule deleted successfully.']);
        }

        flash()->success('Schedule deleted successfully.');
        return redirect()->route('classes.schedules.index', $class);
    }
}
