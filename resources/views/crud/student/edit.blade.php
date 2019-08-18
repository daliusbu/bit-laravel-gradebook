@extends('crud.layouts.layout')

@section('content')

    <h1 class="my-4">Student edit</h1>
    @include('partials.form-errors')
    <div>
        <form action="{{ route('crud.student.edit.save', ['id' => $student->id]) }}" method="POST">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="fname">Name</label>
                <input class="form-control-sm col-sm-8" type="text" name="fname" id="fname" value="{{ $student->name }}">
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="lname">Surname</label>
                <input class="form-control-sm col-sm-8" type="text" name="lname" id="lname" value="{{ $student->surname }}">
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="email">Email</label>
                <input class="form-control-sm col-sm-8" type="email" name="email" id="email" value="{{ $student->email }}">
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="phone">Phone</label>
                <input class="form-control-sm col-sm-8" type="text" name="phone" id="phone" value="{{ $student->phone }}">
            </div>

            <div>
                <button type="submit">Edit</button>&nbsp;
                <a href="{{ route('crud.student.index') }}">Back</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    @parent
    @include('partials.ck-editor')
@endsection