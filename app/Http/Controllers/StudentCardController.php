<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentCard;
use App\Models\PrintTemplate;
use App\Http\Requests\StudentCard\StoreStudentCardRequest;
use App\Http\Requests\StudentCard\UpdateStudentCardRequest;
use Illuminate\Http\Request;

class StudentCardController extends Controller
{
    public function globalIndex(Request $request)
    {
        $query = StudentCard::with('student', 'template')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('khmer_name', 'like', "%{$search}%")
                  ->orWhere('latin_name', 'like', "%{$search}%")
                  ->orWhere('student_code', 'like', "%{$search}%");
            });
        }

        $cards = $query->paginate(50)->withQueryString();
        return view('admin.student_cards.global_index', compact('cards'));
    }

    public function index(Student $student)
    {
        $student->load('cards.template');
        $templates = PrintTemplate::where('template_type', 'student_card')->where('status', 'active')->get();
        return view('admin.student_cards.index', compact('student', 'templates'));
    }

    public function store(StoreStudentCardRequest $request, Student $student)
    {
        StudentCard::create([
            'student_id' => $student->id,
            'template_id' => $request->template_id ?? null,
            'card_no' => 'CARD-' . now()->format('Ymd') . '-' . strtoupper(uniqid()),
            'issue_date' => $request->issue_date ?? now(),
            'expire_date' => $request->expire_date ?? null,
            'status' => 'active',
            'created_by' => auth()->id(),
        ]);

        flash()->success('Student card created successfully.');
        return redirect()->route('students.cards.index', $student);
    }

    public function update(UpdateStudentCardRequest $request, Student $student, StudentCard $card)
    {
        if ($card->student_id !== $student->id) {
            abort(403);
        }
        $card->update([
            'template_id'  => $request->template_id ?? $card->template_id,
            'issue_date'   => $request->issue_date ?? $card->issue_date,
            'expire_date'  => $request->expire_date ?? $card->expire_date,
            'status'       => $request->status ?? $card->status,
            'updated_by'   => auth()->id(),
        ]);
        flash()->success('Student card updated successfully.');
        return redirect()->route('students.cards.index', $student);
    }

    public function print(Student $student, StudentCard $card)
    {
        if ($card->student_id !== $student->id) {
            abort(403);
        }
        $card->load('student.gender', 'student.guardians');
        $card->update([
            'printed_at' => now(),
            'print_count' => ($card->print_count ?? 0) + 1,
        ]);
        return view('admin.student_cards.print', [
            'student' => $card->student,
            'card' => $card,
        ]);
    }

    public function bulkPrint(Request $request)
    {
        $ids = $request->input('card_ids', []);
        if (empty($ids)) {
            flash()->error('Please select at least one card to print.');
            return redirect()->route('student-cards.index');
        }

        $cards = StudentCard::with('student.gender', 'student.guardians')
            ->whereIn('id', $ids)
            ->get();

        foreach ($cards as $card) {
            $card->printed_at = now();
            $card->print_count = ($card->print_count ?? 0) + 1;
            $card->save();
        }

        return view('admin.student_cards.bulk_print', compact('cards'));
    }

    public function destroy(Student $student, StudentCard $card)
    {
        if ($card->student_id !== $student->id) {
            abort(403);
        }
        $card->delete();
        flash()->success('Student card deleted successfully.');
        return redirect()->route('students.cards.index', $student);
    }
}
