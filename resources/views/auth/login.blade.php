@extends('crud.layouts.layout')

@section('content')
<h1>Login</h1>
<div>
<form method="POST" action="{{ route('login') }}">
@csrf
<div>
<label>E-Mail Address</label>
<input id="email" type="text" @error('email') @enderror name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
</div>

<div>
<label>Password</label>
<input id="password" type="password" @error('password') @enderror name="password" required autocomplete="current-password">
</div>
<div>
<button type="submit">Login</button>
@if (Route::has('password.request'))<a href="{{ route('password.request') }}">Forgot Your Password?</a>@endif
</div>
 </form>
 </div>
 @endsection
