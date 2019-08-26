<?php

namespace App\Http\Controllers;

use App\Lecture;
use App\Student;
use Illuminate\Http\Request;
use App\Grade;
use Mews\Purifier\Facades\Purifier;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('sf', $request->session()->get('student_filter', ''));

        // Remember current filter settings
        $request->session()->put('student_filter', $filter);

        // Grade list
        $grades = Grade::orderBy('student_id', 'asc')
            ->with('student')
            ->when($filter, function ($query) use ($filter) {
                return $query->where('student_id', $filter);
            })
            ->paginate(5);

        // Students list for filter choices
        $students = Student::orderBy('surname', 'asc')
            ->has('Grade')
            ->get();
        return view('crud.grade.index', ['grades' => $grades, 'students' => $students]);
    }

    public function view($id)
    {
        $grade = Grade::with('student')->with('lecture')->findOrFail($id);
        return view('crud.grade.view', ['grade' => $grade]);
    }

    public function add()
    {
        $grades = Grade::get();
        $students = Student::orderBy('surname')->get();
        $lectures = Lecture::orderBy('name')->get();
        return view('crud.grade.add', ['grades' => $grades, 'students'=>$students, 'lectures'=>$lectures]);
    }

    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        $student = $grade->student->name. " ". $grade->student->surname;
        $lecture = $grade->lecture->name;
        $students = Student::orderBy('name', 'asc')->get();

        return view('crud.grade.edit', [
            'grade' => $grade,
            'students' => $students,
            'stud'=>$student,
            'lecture'=>$lecture,
        ]);
    }

    /**
     * @param null $id
     * @param Request $request
     * @param Grade $grade
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save($id = null, Request $request, Grade $grade)
    {
        if ($id == null){
            $request->merge([
                'grade' => Purifier::clean($request->grade),
                'student_id' => Purifier::clean($request->studentId),
                'lecture_id' => Purifier::clean($request->lectureId),
            ]);
            $validated = $request->validate([
                'grade' => 'integer|required|min:0|max:10',
                'student_id' => 'integer|required',
                'lecture_id' => 'integer|required',
            ]);
        } else{
            $request->merge([
                'grade' => Purifier::clean($request->grade),
            ]);
            $validated = $request->validate([
                'grade' => 'integer|required|min:0|max:10',
            ]);
        }

        if ($validated) {
            try {
                $grade->updateOrCreate(['id' => $id], $validated);
                return redirect()->to(route('crud.grade.index'));
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            }
            return redirect()->back()->with('danger', 'Uncatchable exception');
        }
        return redirect()->back()->withInput();
    }

    /**
     * @param Request $request
     * @param Grade $grade
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Grade $grade)
    {
        $gradeToDelete = collect($request->input('selected', []));

        if ($gradeToDelete->isNotEmpty()) {
            $grade->destroy($gradeToDelete);
        }

        return redirect()->to(route('crud.grade.index'));
    }
}
