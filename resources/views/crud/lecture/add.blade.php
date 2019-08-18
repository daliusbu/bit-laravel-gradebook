@extends('crud.layouts.layout')

@section('content')
    <h1 class="my-4">Lecture add</h1>
    @include('partials.form-errors')
    <div>
        <form class="col-md-8" action="{{ route('crud.lecture.save') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="name">Name</label>
                <input class="form-control-sm col-sm-8" type="text" name="name" id="fname"
                       value="{{ request()->old('name') }}">
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <label class="col-form-label-sm" for="ck-editor-field">Description</label>
                </div>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="4" cols="80" name="description" id="ck-editor-field" value="">{{ request()->old('description') }}</textarea>
                </div>
            </div>

            <button class="my-4" type="submit">Add Lecture</button>&nbsp;<a href="{{ route('crud.lecture.index') }}">Back</a>
        </form>
    </div>
@endsection

@section('scripts')
    @include('partials.ck-editor')
@endsection