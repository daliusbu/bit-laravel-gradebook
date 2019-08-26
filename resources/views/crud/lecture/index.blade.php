@extends('crud.layouts.layout')

@section('content')
    <h2>Lectures list</h2>

    <div class="my-3">
        <a href="{{ route('crud.lecture.add') }}">ADD </a>
        <a href="#" id="button-trash">&nbsp; DELETE</a>
    </div>
    @if(session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif

    <div>
        <form id="selected-form" method="POST" action="{{ route('crud.lecture.delete') }}">
            @csrf
            @method('DELETE')

            <table class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($lectures as $lecture)
                    <tr>
                        <td>
                            @if (isset($lecture->hasgrade))

                                <input type="checkbox" name="selected[]" value="{{ $lecture->id }}" disabled>&nbsp;
                            @else
                                <input type="checkbox" name="selected[]" value="{{ $lecture->id }}">&nbsp;
                            @endif
                            <a href="{{ route('crud.lecture.edit', ['id' => $lecture->id]) }}">{{ 'Edit' }}</a>
                        </td>
                        <td><a href="{{ route('crud.lecture.view', ['id' => $lecture->id]) }}">{{ $lecture->name }}</a></td>
                        <td>{!! $lecture->description !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </form>

        <div class="pagination pagination-sm justify-content-center">
            {{ $lectures->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Trash form submit
            document.getElementById('button-trash').addEventListener('click', function () {
                document.getElementById('selected-form').submit();
            });
            // Select all checkbox
            document.getElementById('select-all').addEventListener('click', function () {
                check = this.checked;
                boxes = document.querySelectorAll('input[name="selected[]"]:not(:disabled)');
                boxes.forEach(function (item) {
                    item.checked = check;
                });
            });
            // Filter form submit on select change
            document.getElementById('list-filter').addEventListener('change', function () {
                document.getElementById('filter-form').submit();
            });
        }, false);
    </script>
@endsection