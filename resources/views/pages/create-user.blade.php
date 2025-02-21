@extends('layouts.master')

@section('title')
Create User
@endsection
@section('content')
    <div class="container m-3 bg-light rounded">
        <div class="row ">
            <div>
                <h4>{{__('en.Create User')}}</h4>
            </div>
        </div>
        <hr>
        <form method="POST" action="">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 pt-1">
                    <label for="Fname" class="form-label fs-6">{{__('en.First Name')}} : </label>
                    <input type="text" class="form-control mb-2 border-dark @error('Fname') is-invalid @enderror" id="Fname" name="Fname"
                        placeholder="Elon" value="{{ old('Fname') }}" autocomplete="Fname" required autofocus>
                    @error('Fname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-lg-4 col-md-6 col-12 pt-1">
                    <label for="Lname" class="form-label fs-6">{{__('en.Last Name')}} : </label>
                    <input type="text" class="form-control mb-2 border-dark @error('Lname') is-invalid @enderror" id="Lname" name="Lname"
                        placeholder="Musk" value="{{ old('Lname') }}" autocomplete="Lname" required>
                    @error('Lname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-lg-4 col-md-6 col-12 pt-1">
                    <label for="name" class="form-label fs-6">{{__('en.Username')}} : </label>
                    <input type="text" class="form-control mb-2 border-dark @error('name') is-invalid @enderror" name="name" id="name"
                        placeholder="Elon Musk" value="{{ old('name') }}" autocomplete="name" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-lg-4 col-md-6 col-12 pt-1">
                    <label for="Group" class="form-label fs-6">{{__('en.Group')}} : </label>
                    <select class="form-select mb-2 border-dark @error('Group') is-invalid @enderror" multiple name="Group" id="Group" autocomplete="Group" required>
                        <option>{{__('en.Choose')}}</option>
                        <option value="1" @if(old('Group') == 1) 'selected' @endif >{{__('en.Group')}} 1</option>
                        <option value="2" @if(old('Group') == 2) 'selected' @endif >{{__('en.Group')}} 2</option>
                    </select>                                                
                    @error('Group')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-lg-4 col-md-6 col-12 pt-1">
                    <label for="Phone" class="form-label fs-6">{{__('en.Phone')}} : </label>
                    <input type="phone" class="form-control mb-2 border-dark @error('Phone') is-invalid @enderror" id="Phone" name="Phone"
                        placeholder="+923001234567" value="{{ old('Phone') }}" autocomplete="Phone" required>
                    @error('Phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-lg-4 col-md-6 col-12 pt-1">
                    <label for="Email" class="form-label fs-6">{{__('en.Email')}} : </label>
                    <input type="email" class="form-control mb-2 border-dark @error('Email') is-invalid @enderror" id="Email" name="Email"
                        placeholder="abc123@example.com" value="{{ old('Email') }}" autocomplete="Email" required>
                    @error('Email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-lg-4 col-md-6 col-12 pt-1">
                    <label for="Password" class="form-label fs-6">{{__('en.Password')}} : </label>
                    <input type="password" class="form-control mb-2 border-dark @error('Password') is-invalid @enderror" id="Password" name="Password"
                        value="{{ old('Password') }}" placeholder="********" autocomplete="Password" required>
                    @error('Password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-lg-4 col-md-6 col-12 pt-1">
                    <label for="ConfirmPassword" class="form-label fs-6">{{__('en.Confirm Password')}} : </label>
                    <input type="password" class="form-control mb-2 border-dark @error('ConfirmPassword') is-invalid @enderror" id="ConfirmPassword" name="ConfirmPassword"
                        value="{{ old('ConfirmPassword') }}" placeholder="********" autocomplete="ConfirmPassword" required>
                    @error('ConfirmPassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <!-- save button row included below -->
            @include('pages.table-footer')
        </form>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on('change','#imageInput', function (event) {
            
                const file = event.target.files[0]; // Get the selected file

                if (file) {
                    const reader = new FileReader(); // Create a FileReader instance
                    reader.onload = function (e) {
                        $('#previewImage')
                            .attr('src', e.target.result) // Set the image source
                            .show(); // Show the image
                    };
                    reader.readAsDataURL(file); // Read the file as a data URL
                } else {
                    $('#previewImage').hide(); // Hide the preview if no image is selected
                    alert('Please select a valid image file!');
                }
            });
        });
    </script>
@endsection