@extends('crud.layouts.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Log In</h5>
                        <form class="form-signin" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-label-group">
                                <input class="form-control" id="email" type="text"
                                       @error('email') @enderror name="email"
                                       value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <label for="email">Username</label>
                            </div>
                            <div class="form-label-group">
                                <input class="form-control" id="password" type="password"
                                       @error('password') @enderror name="password"
                                       required autocomplete="current-password">
                                <label for="password">Password</label>
                            </div>
                            <button class="btn btn-primary btn-block text-uppercase my-3" type="submit">Log in</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
