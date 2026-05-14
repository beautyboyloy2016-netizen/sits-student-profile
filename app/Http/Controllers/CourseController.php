<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Level;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Requests\Course\StoreLevelRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Course::withCount('classes')->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status_badge', fn($r) => '<span class="badge badge-'.($r->status==='active'?'success':'secondary').'">'.ucfirst($r->status).'</span>')
                ->addColumn('action', function ($row) {
                    $edit = '<button class="btn btn-xs btn-warning btn-edit-course mr-1"
                        data-id="'.$row->id.'" data-name="'.e($row->name).'"
                        data-description="'.e($row->description).'" data-status="'.$row->status.'"
                        ><i class="fas fa-edit"></i></button>';
                    $delete = '<form action="'.route('courses.destroy', $row->id).'" method="POST" class="d-inline">
                        '.csrf_field().'<input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-xs btn-danger btn-swal-delete"><i class="fas fa-trash"></i></button>
                        </form>';
                    return $edit . $delete;
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }
        return view('admin.courses.index', [
            'courses' => Course::orderBy('name')->get(),
        ]);
    }

    public function store(StoreCourseRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Course::create($validated);
        flash()->success('Course created successfully.');
        return redirect()->route('courses.index');
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $course->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Course updated successfully.', 'course' => $course]);
        }

        flash()->success('Course updated successfully.');
        return redirect()->route('courses.index');
    }

    public function destroy(Course $course)
    {
        try {
            $course->delete();
            flash()->success('Course deleted successfully.');
        } catch (\Exception $e) {
            flash()->error('Cannot delete course with existing classes.');
        }

        return redirect()->route('courses.index');
    }

    public function storeLevel(StoreLevelRequest $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $level = Level::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'message' => 'Level created successfully.',
                'level' => $level,
            ]);
        }

        flash()->success('Level created successfully.');
        return redirect()->route('courses.index');
    }
}
