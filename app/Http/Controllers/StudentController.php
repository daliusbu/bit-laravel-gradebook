<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('sf', $request->session()->get('student_filter', ''));
        $request->session()->put('student', $filter);
        $students = Student::orderBy('surname', 'asc')
            ->paginate(5);

        return view('crud.student.index', ['students' => $students]);
    }


    public function add()
    {
        return view('crud.student.add', []);
    }


    public function edit($id)
    {
        $student = Student::findOrFail($id);

        return view('crud.student.edit', [
            'student' => $student,
        ]);
    }


    public function save($id = null, Request $request, Student $student)
    {
        $request->merge([
            'name' => Purifier::clean($request->fname),
            'surname' => Purifier::clean($request->lname),
            'email' => Purifier::clean($request->email),
            'phone' => Purifier::clean($request->phone),
        ]);
        $validated = $request->validate([
            'name' => 'string|required|max:255',
            'surname' => 'string|required|max:255',
            'email' => 'string|required|max:255',
            'phone' => 'string|required|max:30',
        ]);

        if ($validated) {
            try {
                $student->updateOrCreate(['id' => $id], $validated);
                return redirect()->to(route('crud.student.index'));
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            }
            return redirect()->back()->with('danger', 'Uncatchable exception');
        }
        return redirect()->back()->withInput();
    }


    public function delete(Request $request, Student $student)
    {
        $toBeDeleted = collect($request->input('selected', []));

        if ($toBeDeleted->isNotEmpty()) {
            try{
                $student->destroy($toBeDeleted);
            } catch (QueryException $e){
                return redirect()->back()->with('message', 'Cannot delete Student which has grades assigned to.');
            }
        }

        return redirect()->to(route('crud.student.index'));
    }
}
