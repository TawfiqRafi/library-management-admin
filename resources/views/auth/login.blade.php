@extends('layouts.app')

@section('content')
    <div class="auth-box login-box">
        <div class="auth-box-header">
            <h2 class="auth-box-title">Welcome Back!</h2>
        </div>
        <div class="auth-box-body">
            {!! Form::open(['route' => 'login', 'method' => 'POST']) !!}
            <div class="form-group @error('email') has-error @enderror">
                <label for="">Email</label>
                <div class="input-group">
                        <span class="input-group-icon">
                            <i class="bx bx-user"></i>
                        </span>
                    <input type="text" name="email" placeholder="email" class="form-control" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group @error('password') has-error @enderror">
                <label for="">Password</label>
                <div class="input-group">
                            <span class="input-group-icon">
                                <i class="bx bx-lock-open"></i>
                            </span>
                    <input type="password" name="password" placeholder="********" class="form-control">
                </div>
                @error('password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-submit">
                <button type="submit" class="submit-btn">Log In</button>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="auth-box-footer">

        </div>
    </div>
@endsection
