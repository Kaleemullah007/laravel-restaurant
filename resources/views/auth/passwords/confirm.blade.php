@extends('layouts.app')

@section('content')



<div class="log-in d-flex justify-content-center" style="background-image: url(/auth/log-in.jpg);">
    <div class="sign-in-css bg-light my-4">
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            @include('auth.logo')

            <div class="row text-center">
                <h3>    {{ __('auth.password_confirmation') }}</h3>

            </div>
            <div class="row m-3 ">
                <div class="col-12">
                    <label for="email-address" class="form-label fs-6">{{ __('auth.Password') }}</label>
                </div>
                <div class="col-12">
                    <input id="password" type="password" autofocus placeholder="*******" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
            </div>
            <div class="row mt-4 justify-content-center">
                <div class="col-8">
                    <button type="submit" class="btn btn-success rounded-pill w-100">
                        {{ __('auth.Confirm_Password') }}
                    </button>
                </div>
            </div>

            @if (Route::has('password.request'))
            <div class="row my-2 text-center">
                <a class="anchor-css" href="{{ route('password.request') }}">
                    {{ __('auth.Forgot_Your_Password') }}
                </a>
            </div>
            @endif

        </form>
    </div>


</div>

@endsection
