@extends('crud.layouts.layout')

@section('content')
    <h1>Grade add</h1>
    @include('partials.form-errors')
    <div>
        <form action="{{ route('crud.grade.save') }}" method="POST">
            @csrf
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th>Student</th>
                    <th>Lecture</th>
                    <th>Grade</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <select name="studentId" id="student-filter">
                            <option value="">--All--</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}"
                                        @if ($student->id == request()->old('studentId')) selected @endif>{{ $student->name }} {{ $student->surname }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="lectureId" id="lecture-filter">
                            <option value="">--All--</option>
                            @foreach ($lectures as $lecture)
                                <option value="{{ $lecture->id }}"
                                        @if ($lecture->id ==  request()->old('lectureId')) selected @endif>{{ $lecture->name }} {{ $lecture->surname }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="col-sm-3 input-group-sm" type="text" name="grade" value="{{ request()->old('grade') }}">
                    </td>
                </tr>
                </tbody>
            </table>
            <div>
            </div>
            <div>
                <button type="submit">Add Grade</button>&nbsp;<a href="{{ route('crud.grade.index') }}">Back</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    @include('partials.ck-editor')
@endsection