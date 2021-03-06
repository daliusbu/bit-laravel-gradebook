@extends('crud.layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Student grade</h1>
        </div>
        <div class="card-body">
            @include('partials.form-errors')
            <table class="table">
                <thead>
                <tr>
                    <th>Student</th>
                    <th>Lecture</th>
                    <th>Grade</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $grade->student->name }}</td>
                    <td>{{ $grade->lecture->name }}</td>
                    <td>{{ $grade->grade }}</td>
                </tr>
                </tbody>
            </table>

            <div class="">
                <a href="{{ route('crud.grade.index') }}"><-- Back</a>&nbsp;
                @auth
                    <a href="{{ route('crud.grade.edit', ['id'=>$grade->id]) }}"><button type="submit">Edit</button></a>
                @endauth
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    @include('partials.ck-editor')
@endsection