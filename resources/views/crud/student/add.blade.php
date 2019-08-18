@extends('crud.layouts.layout')

@section('content')
    <h1>Student add</h1>
    @include('partials.form-errors')
    <div>
        <form class="col-md-8" action="{{ route('crud.student.save') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="fname">Name</label>
                <input class="form-control-sm col-sm-8" type="text" name="fname" id="fname" value="{{ request()->old('fname') }}">
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="lname">Surame</label>
                <input class="form-control-sm col-sm-8" type="text" name="lname" id="lname" value="{{ request()->old('lname') }}">
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="email">Email</label>
                <input class="form-control-sm col-sm-8" type="email" name="email" id="email" value="{{ request()->old('email') }}">
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="phone">Phone</label>
                <input class="form-control-sm col-sm-8" type="text" name="phone" id="phone" value="{{ request()->old('phone') }}">
            </div>
            <div>
                <button type="submit">Add Student</button>&nbsp;<a href="{{ route('crud.student.index') }}">Back</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    @include('partials.ck-editor')
@endsection