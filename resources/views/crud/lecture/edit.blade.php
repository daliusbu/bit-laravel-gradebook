@extends('crud.layouts.layout')

@section('content')

    <h1 class="my-4">Lecture edit</h1>
    @include('partials.form-errors')
    <div>
        <form action="{{ route('crud.lecture.edit.save', ['id' => $lecture->id]) }}" method="POST">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="name">Name</label>
                <input class="form-control-sm col-sm-8" type="text" name="name" id="fname"
                       value="{{ $lecture->name }}">
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <label class="col-form-label-sm" for="ck-editor-field">Description</label>
                </div>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="4" cols="80" name="description" id="ck-editor-field" value="">{{ $lecture->description }}</textarea>
                </div>
            </div>


            <div>
                <button type="submit">Edit</button>&nbsp;
                <a href="{{ route('crud.lecture.index') }}">Back</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    @parent
    @include('partials.ck-editor')
@endsection