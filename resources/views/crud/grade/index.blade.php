@extends('crud.layouts.layout')

@section('content')
    <h2>Student grades</h2>
    <div class="my-3">
        <form action="{{ route('crud.grade.index') }}" method="GET" id="filter-form">
            <select name="sf" id="list-filter">
                <option value="">{{ __('--All--') }}</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}"
                            @if ($student->id === intval(session('student_filter'))) selected @endif>{{ $student->name }} {{ $student->surname }}</option>
                @endforeach
            </select>
        </form>
    </div>
    @auth
        <div class="my-3">
            <a href="{{ route('crud.grade.add') }}">ADD </a>
            <a href="#" id="button-trash">&nbsp; DELETE</a>
        </div>
    @endauth

    <div>
        <form id="selected-form" method="POST" action="{{ route('crud.grade.delete') }}">
            @csrf
            @method('DELETE')

            <table class="table table-responsive table-striped">
                <thead>
                <tr>
                    @auth
                        <th><input type="checkbox" id="select-all"></th>
                    @endauth
                    <th>Student</th>
                    <th>Lecture</th>
                    <th>Grade</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($grades as $grade)
                    <tr>
                        @auth
                            <td><input type="checkbox" name="selected[]" value="{{ $grade->id }}">&nbsp;
                                <a href="{{ route('crud.grade.edit', ['id' => $grade->id]) }}">{{ 'Edit' }}</a>
                            </td>
                        @endauth
                        <td>
                            <a href="{{ route('crud.grade.view', ['id' => $grade->id] )}}">{{ $grade->student->name }} {{ $grade->student->surname }}</a>
                        </td>

                        <td>{{ $grade->lecture->name }}</td>
                        <td>{{ $grade->grade }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </form>

        <div class="pagination pagination-sm justify-content-center">
            {{ $grades->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Trash form submit
            @auth
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
            @endauth
            // Filter form submit on select change
            document.getElementById('list-filter').addEventListener('change', function () {
                document.getElementById('filter-form').submit();
            });
        }, false);
    </script>
@endsection
