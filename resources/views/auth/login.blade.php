@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">{{ __('Iniciar sesión') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" class="row g-3">
                        @csrf
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <label for="email" class="form-label">{{ __('Usuario') }}</label>
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Iniciar Sesión') }}
                            </button>
                        </div>


                       <!-- <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->

                            <!--
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">


                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                                -->

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
