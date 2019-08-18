<?php

namespace App\Http\Controllers;

use App\Lecture;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use mysql_xdevapi\Exception;

class LectureController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('sf', $request->session()->get('lecture_filter', ''));
        $request->session()->put('lecture', $filter);
        $lectures = Lecture::orderBy('name', 'asc')
            ->paginate(5);

        return view('crud.lecture.index', ['lectures' => $lectures]);
    }


    public function add()
    {
        return view('crud.lecture.add', []);
    }


    public function edit($id)
    {
        $lecture = Lecture::findOrFail($id);

        return view('crud.lecture.edit', [
            'lecture' => $lecture,
        ]);
    }


    public function save($id = null, Request $request, Lecture $lecture)
    {
        $request->merge([
            'name' => Purifier::clean($request->name),
            'description' => Purifier::clean($request->description),
        ]);
        $validated = $request->validate([
            'name' => 'string|required|max:255',
            'description' => 'string|required|min:30',
        ]);

        if ($validated) {
            try {
                $lecture->updateOrCreate(['id' => $id], $validated);
                return redirect()->to(route('crud.lecture.index'));
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', $e->getMessage())->withInput();
            }
            return redirect()->back()->with('danger', 'Uncatchable exception');
        }
        return redirect()->back()->withInput();
    }


    public function delete(Request $request, Lecture $lecture)
    {
        $toBeDeleted = collect($request->input('selected', []));

        if ($toBeDeleted->isNotEmpty()) {
            try{
                $lecture->destroy($toBeDeleted);
            } catch (QueryException $e){
                return redirect()->back()->with('message', 'Cannot delete Lecture which has grades assigned to.');
            }
        }

        return redirect()->to(route('crud.lecture.index'));
    }
}
