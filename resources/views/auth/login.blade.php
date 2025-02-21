@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="log-in d-flex justify-content-center" style="background-image: url(/auth/log-in.jpg);">
        <div class="sign-in-css bg-light">

            @include('auth.logo')
            @error('message')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            {{-- @dd($errors->all()); --}}
            @enderror
            <div class=" text-center">
                <h3>{{ __('auth.Sign_In') }} </h3>
                <p class="fw-bold">{{ __('tester@rktech.com') }}</p>
                <p>{{ __('password') }}</p>
            </div>
            <div class=" m-3 ">
                <div class="col-12">
                    <label for="email-address" class="form-label fs-6">{{ __('auth.Email_Address') }}</label>
                </div>
                <div class="col-12">
                    <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Abc123@example.com" aria-label="email-address">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
            </div>
            <div class=" m-3 ">
                <div class="col-12">
                    <label for="password" class="form-label fs-6">{{ __('auth.Password') }}</label>
                </div>
                <div class="col-12">
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="******" aria-label="password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class=" ">
                <div class="col-sm-12 ">
                    <div class="form-check d-flex justify-content-center text-center">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class=" ms-4 form-check-label" for="remember">
                            {{ __('auth.Remember_Me') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-flex mt-4 justify-content-center">
                <div class="col-8">
                    <button type="submit" class="btn btn-success rounded-pill w-100">
                        {{ __('auth.Sign_In') }}
                    </button>
                    {{-- <a href="#" class="btn btn-success rounded-pill w-100">Sign In</a> --}}
                </div>
            </div>
            <div class=" my-2 text-center">
                @if (Route::has('password.request'))
                <a class="anchor-css" href="{{ route('password.request') }}">
                    {{ __('auth.Forgot_Your_Password') }}
                </a>
                @endif

            </div>
            {{-- <div class=" mb-4 justify-content-center">
                <div class="col-8">
                    {{ langUrl('register') }}
                    <a href="#" class="btn btn-danger rounded-pill w-100">
                        {{ __('auth.Sign_Up') }}
                    </a>
                </div>
            </div> --}}

        </div>
    </div>
</form>

@endsection

