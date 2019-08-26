@extends('crud.layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Lecture</h1>
        </div>
        <div class="card-body">
            @include('partials.form-errors')
            <table class="table">
                <thead>
                <tr>
                    <th>Lecture</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $lecture->name }}</td>
                    <td>{!! $lecture->description !!}</td>
                </tr>
                </tbody>
            </table>

            <div class="">
                <a href="{{ route('crud.lecture.index') }}"><-- Back</a>&nbsp;
                @auth
                    <a href="{{ route('crud.lecture.edit', ['id'=>$lecture->id]) }}">
                        <button type="submit">Edit</button></a>
                @endauth
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    @include('partials.ck-editor')
@endsection