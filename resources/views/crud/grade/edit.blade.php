@extends('crud.layouts.layout')

@section('content')

    <h1>Student grade edit</h1>
    @include('partials.form-errors')
    <div>
        <form action="{{ route('crud.grade.edit.save', ['id' => $grade->id]) }}" method="POST">
            @method('PUT')
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
                    <td>{{ $stud }}</td>
                    <td>{{ $lecture }}</td>
                    <td>
                        <input class="col-sm-3" type="text" name="grade" value="{{ $grade->grade }}">
                    </td>
                </tr>
                </tbody>
            </table>

            <div>
                <button type="submit">Edit</button>&nbsp;
                <a href="{{ route('crud.grade.index') }}">Back</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    @parent
    @include('partials.ck-editor')
@endsection