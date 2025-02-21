@extends('layouts.master')

@section('title')
    {{ __('profile.Profile_Setting') }}
@endsection
@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('profile.Profile_Setting') }} {{auth()->user()->start_date }} @if(!is_null(auth()->user()->end_date)) - {{auth()->user()->end_date}} @endif</h4>
                </div>
            </div>
            <hr>
            @include('message')
            <form method="POST" action="{{ route('profile-update') }}" enctype="multipart/form-data">
                @csrf
                <div class="row d-flex justify-content-around mt-3">
                    <div class="col-lg-9 col-12">
                        <div class="row d-flex">
                            <div class="col-lg-6 col-md-6 col-12 pt-2">
                                <label for="name" class="form-label pt-1 fs-6">{{ __('profile.First_Name') }}</label>
                                <input type="text"

                                    class="form-control border-dark  @error('firstName') is-invalid @enderror"
                                    id="firstName" name="firstName" value="{{ old('firstName', auth()->user()->first_name) }}"
                                    autocomplete="firstName" required>
                                @error('firstName')

                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 pt-2">
                                <label for="lastName" class="form-label pt-1 fs-6">{{ __('profile.Last_Name') }}</label>
                                <input type="text"
                                    class="form-control border-dark  @error('lastName') is-invalid @enderror"
                                     id="lastName" name="lastName"
                                    value="{{ old('lastName', auth()->user()->last_name) }}" autocomplete="lastName" required>
                                @error('lastName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 pt-2">
                                <label for="dob" class="form-label pt-1 fs-6">{{ __('profile.Date_of_Birth') }}</label>
                                <input type="date" class="form-control  @error('dob') is-invalid @enderror"
                                    id="dob" name="dob" value="{{ old('dob', date('Y-m-d')) }}" autocomplete="dob"
                                    >
                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 pt-2">
                                <label for="status" class="form-label pt-1 fs-6">{{ __('profile.Status') }}</label>
                                <div class="fw-bold">
                                    <input type="checkbox" class="" data-toggle="toggle" data-onstyle="success"
                                        data-offstyle="danger" checked data-size="sm" data-on="{{ __('profile.Active') }}" data-off="{{ __('profile.Inactive') }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 pt-2">
                                <label for="password" class="form-label pt-1 fs-6">{{ __('profile.Password') }}</label>
                                <input type="password" class="form-control  @error('password') is-invalid @enderror"
                                    minlength="8" value="" id="password" name="password"
                                    value="{{ old('password') }}" autocomplete="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 pt-2">
                                <label for="conPassword"
                                    class="form-label pt-1 fs-6">{{ __('profile.Confirm_Password') }}</label>
                                <input type="password" class="form-control  @error('conPassword') is-invalid @enderror"
                                    minlength="8" value="" id="conPassword" name="conPassword"
                                    value="{{ old('conPassword') }}" autocomplete="conPassword">
                                @error('conPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <div class="col-lg-6 col-md-6 col-12 pt-2">
                                <label for="secQuestionOne"
                                    class="form-label pt-1 fs-6">What was the City you born in?</label>
                                <input type="text" class="form-control  @error('secQuestionOne') is-invalid @enderror"
                                    id="secQuestionOne" name="secQuestionOne"
                                    value="{{ old('secQuestionOne',auth()->user()->address) }}" autocomplete="secQuestionOne"  >
                                @error('secQuestionOne')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}
                            {{-- <div class="col-lg-6 col-md-6 col-12 pt-2">
                                <label for="secQuestionTwo"
                                    class="form-label pt-1 fs-6">What is the City you are living in?</label>
                                <input type="text" class="form-control  @error('secQuestionTwo') is-invalid @enderror"
                                    value="Islamabad" id="secQuestionTwo" name="secQuestionTwo"
                                    value="{{ old('secQuestionTwo') }}" autocomplete="secQuestionTwo"  >
                                @error('secQuestionTwo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12 p-4">
                        @php
                        // dd(auth()->user()->picture);
                            if (file_exists('images/' . auth()->user()->picture)) {
                                $image = '/images/' . auth()->user()->picture;
                            } else {
                                $image = '/assets/images/user1.png';
                            }

                        @endphp

                        <img class="img img-thumbnail d-block mx-auto  h-75" src="{{ $image }}" alt="">
                        <div class="d-flex justify-content-center">
                            <input type="file"
                                class="w-75 mt-4 form-control float-center  @error('profileImg') is-invalid @enderror"
                                id="profileImg" name="profileImg" value="{{ old('profileImg') }}"
                                autocomplete="profileImg">
                        </div>
                    </div>
                </div>
                <div class="row p-2 mt-4">
                    <div class="col-lg-12 col-12 shadow-css">
                        <div class="row bg-grey py-3">
                            <h5>{{ __('profile.General_Setting') }}</h5>
                        </div>
                        {{-- @dd(auth()->user()->currency); --}}
                        <div class="row d-flex justify-content-around mt-3 py-2 pb-4">
                            <div class="col-lg-9 col-12">
                                <div class="row d-flex">
                                    <div class="col-lg-6 col-md-6 col-12 mt-2">
                                        <label for="currency" class="form-label  fs-6">{{ __('profile.Currency') }}</label>
                                        <select
                                            class="form-select mb-2 border-dark @error('currency') is-invalid @enderror"
                                            name="currency" id="currency" autocomplete="currency" >
                                            <option value="$" @if (old('currency',auth()->user()->currency) == '$') selected @endif>US
                                                Dollar
                                            </option>
                                            <option value="Rs." @if (old('currency',auth()->user()->currency) == 'Rs.') selected @endif>PKR
                                            </option>
                                        </select>
                                        @error('currency')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mt-2">
                                        <label for="date_format"
                                            class="form-label  fs-6">{{ __('profile.Date_Format') }}</label>
                                        <select
                                            class="form-select mb-2 border-dark @error('date_format') is-invalid @enderror"
                                            name="date_format" id="date_format" autocomplete="date_format" >

                                            <option value="m-d-Y" @if (old('date_format') == 'm-d-Y') 'selected' @endif>
                                                m-d-Y
                                            </option>
                                            <option value="d-m-Y" @if (old('date_format') == 'd-m-Y') 'selected' @endif>
                                                d-m-Y
                                            </option>
                                            <option value="Y-m-d" @if (old('date_format') == 'Y-m-d') 'selected' @endif>
                                                Y-m-d
                                            </option>
                                        </select>
                                        @error('date_format')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mt-2">
                                        <label for="current_template"
                                            class="form-label  fs-6">{{ __('profile.Current_Template') }}</label>
                                        <select
                                            class="form-select mb-2 border-dark @error('current_template') is-invalid @enderror"
                                            name="current_template" id="current_template" autocomplete="current_template"
                                            >

                                            <option value="view-sale" @if (old('current_template',auth()->user()->invoice_template) == 'view-sale') selected @endif>
                                                Template 1
                                            </option>
                                            <option value="view-sale-1"
                                                @if (old('current_template',auth()->user()->invoice_template) == 'view-sale-1') selected @endif>Template 2
                                            </option>
                                            <option value="view-sale-2"
                                                @if (old('current_template',auth()->user()->invoice_template) == 'view-sale-2') selected @endif>Template 3
                                            </option>
                                            <option value="view-sale-3"
                                                @if (old('current_template',auth()->user()->invoice_template) == 'view-sale-3') selected @endif>Template 4
                                            </option>
                                        </select>
                                        @error('current_template')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mt-2">
                                        <label for="business_phone"
                                            class="form-label  fs-6">{{ __('profile.Business_Phone') }}</label>
                                        <input type="text"
                                            class="form-control border-dark  @error('business_phone') is-invalid @enderror"
                                            id="business_phone" name="business_phone" placeholder="+923001234567"
                                            value="{{ old('business_phone', auth()->user()->business_phone) }}"
                                            autocomplete="business_phone" >
                                        @error('business_phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mt-2">
                                        <label for="business_email"
                                            class="form-label  fs-6">{{ __('profile.Business_Email') }}</label>
                                        <input type="email"
                                            class="form-control border-dark  @error('business_email') is-invalid @enderror"
                                            id="business_email" name="business_email" placeholder="abc123@example.com"
                                            value="{{ old('business_email', auth()->user()->business_email) }}"
                                            autocomplete="business_email" >
                                        @error('business_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mt-2">
                                        <label for="address" class="form-label  fs-6">{{ __('profile.Address') }}</label>
                                        <input type="text"
                                            class="form-control border-dark  @error('address') is-invalid @enderror"
                                            id="address" name="address" placeholder="236, chemin Hortense Berger"
                                            value="{{ old('address', auth()->user()->address) }}" autocomplete="address"
                                            >
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 pt-2">
                                        <label for="status" class="form-label pt-1 fs-6">{{ __('profile.email_sending') }}</label>
                                        <div class="fw-bold">
                                            <input type="checkbox" class="" data-toggle="toggle" data-onstyle="success" name="sent_email"
                                                data-offstyle="danger" @checked(auth()->user()->send_emails) data-width="100" data-on="{{ __('profile.Yes') }}" data-off="{{ __('profile.NO') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 pt-2">
                                        <label for="status" class="form-label pt-1 fs-6">{{ __('users.price_change') }}</label>
                                        <div class="fw-bold">
                                            <input type="checkbox" class="" data-toggle="toggle" data-onstyle="success" name="change_price"
                                                data-offstyle="danger"  data-width="100" data-on="{{ __('users.Yes') }}" data-off="{{ __('users.NO') }}" @checked(auth()->user()->change_price)>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 p-4">
                                @php
                                    if (file_exists('images/' . auth()->user()->logo)) {
                                        $image = '/images/' . auth()->user()->logo;
                                    } else {
                                        $image = '/assets/images/user1.png';
                                    }
                                @endphp

                                <img class="img img-thumbnail d-block mx-auto  h-75" src="{{ $image }}"
                                    alt="">
                                <div class="d-flex justify-content-center">
                                    <input type="file"
                                        class="w-75 mt-4 form-control float-center  @error('logo') is-invalid @enderror"
                                        id="logo" name="logo" value="{{ old('logo') }}"
                                        autocomplete="logo">
                                </div>
                            </div>

                            {{-- <div class="col-lg-4 col-md-6 col-12 mt-2">
                                <label for="logo" class="form-label  fs-6">{{ __('profile.Logo') }}</label>
                                <input type="file"
                                    class="form-control border-dark  @error('logo') is-invalid @enderror" id="logo"
                                    name="logo" value="{{ old('logo') }}" autocomplete="logo">
                                @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}
                        </div>
                    </div>
                </div>
                <!-- save button row included below -->
                @include('pages.table-footer', ['link' => 'user-profile-setting'])
            </form>
        </div>
    </div>
@endsection
