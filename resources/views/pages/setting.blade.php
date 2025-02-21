@extends('layouts.master')

@section('title')
Settings
@endsection
@section('content')
    <div class="container">
        <div class="container">
            <div class="row pt-3">
                <div class="col-12">
                    <h4>{{__('en.Settings')}}</h4>
                </div>
            </div>
            <hr>
            <div class="row p-3">
                <div class="col-12 shadow-css">
                    {{-- form for general setting --}}
                    <form method="POST" action="">
                        <div class="row pt-2">
                            <div class="col-lg-4 col-md-6 col-12 mt-3">
                                <label for="settingName" class="form-label fs-6">{{__('en.Name')}}</label>
                                <input type="text" class="form-control border-secondary @error('settingName') is-invalid @enderror" id="settingName" name="settingName"
                                value="Name 1" value="{{ old('settingName') }}" autocomplete="settingName" required>
                                @error('settingName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 mt-3">
                                <label for="settingValue" class="form-label fs-6">{{__('en.Value')}} </label>
                                <input type="text" class="form-control border-secondary @error('settingValue') is-invalid @enderror" id="settingValue" name="settingValue"
                                    value="Value 1" value="{{ old('settingValue') }}" autocomplete="settingValue" required>
                                @error('settingValue')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 mt-3">
                                <label for="settingAction" class="form-label fs-6">{{__('en.Action')}}</label><br>
                                <button type="button" class="btn btn-danger"><i class="bi bi-dash-lg"></i></button>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 mt-3">
                                <input type="text" class="form-control border-secondary @error('settingName') is-invalid @enderror" id="settingName" name="settingName"
                                value="Name 2" value="{{ old('settingName') }}" autocomplete="settingName" required>
                                @error('settingName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 mt-3">
                                <input type="text" class="form-control border-secondary @error('settingValue') is-invalid @enderror" id="settingValue" name="settingValue"
                                    value="Value 2" value="{{ old('settingValue') }}" autocomplete="settingValue" required>
                                @error('settingValue')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 mt-3">
                                <button type="button" class="btn btn-success"><i class="bi bi-plus-lg"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <!-- save button row included below -->
                            @include('pages.table-footer')
                        </div>
                    </form>
                    {{-- end form general setting --}}                    
                </div>
            </div>

        </div>
    </div>

@endsection
