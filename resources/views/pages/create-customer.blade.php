@extends('layouts.master')

@section('title')
    {{ __('users.Create_User') }}
@endsection

@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('users.Create_User') }}</h4>
                </div>
            </div>
            <hr>
            <div class="row p-3">
                <div class="shadow-css">
                    @include('message')
                    <form method="POST" action="{{ route('customer.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="first_name" class="form-label fs-6">{{ __('users.First_Name') }}</label>
                                <input type="text"
                                    class="form-control mb-2 border-dark @error('first_name') is-invalid @enderror"
                                    id="first_name" name="first_name" @if(placeholderVisible()) placeholder={{ __('users.First_Name')}}@endif
                                    value="{{ old('first_name') }}" autocomplete="first_name" required autofocus>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="last_name" class="form-label fs-6">{{ __('users.Last_Name') }}</label>
                                <input type="text"
                                    class="form-control mb-2 border-dark @error('last_name') is-invalid @enderror"
                                    id="last_name" name="last_name" @if(placeholderVisible()) placeholder={{ __('users.Last_Name')}}@endif
                                    value="{{ old('last_name') }}" autocomplete="last_name" required autofocus>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="role" class="form-label fs-6">{{ __('users.Role') }}</label>
                                <select
                                    class="form-control mb-2 border-dark"
                                    id="user_type" name="user_type" 
                                    value="{{ old('user_type') }}"  onchange="hello()">
                                    <option value="vendor" >{{ __('users.Vendor') }}</option>
                                    <option value="employee">{{ __('users.employee') }}</option>
                                    <option value="customer" selected>{{ __('users.customer') }}</option>
                                    @if(auth()->user()->user_type == 'superadmin')
                                    <option value="admin" selected>{{ __('users.admin') }}</option>    
                                    <option value="tester" selected>{{ __('users.tester') }}</option>    

                                    
                                    @endif
                                    
                                </select>
                                @error('user_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="phone" class="form-label fs-6">{{ __('users.Phone') }}</label>
                                <input type="phone"
                                    class="form-control mb-2 border-dark @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" @if(placeholderVisible()) placeholder={{ __('03001234567')}}@endif
                                    value="{{ old('phone') }}" autocomplete="phone" required autofocus>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="email" class="form-label fs-6">{{ __('users.Email') }}</label>
                                <input type="email"
                                    class="form-control mb-2 border-dark @error('email') is-invalid @enderror"
                                    id="email" name="email" @if(placeholderVisible()) placeholder={{ __('abc123@example.com')}}@endif
                                    value="{{ old('email') }}" autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="password" class="form-label fs-6">{{ __('users.Password') }}</label>
                                <input type="password"
                                    class="form-control mb-2 border-dark @error('password') is-invalid @enderror"
                                    id="password" name="password" value=""
                                    autocomplete="password" autofocus>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 col-12 pt-2" style="display: none" id="pricenable">
                                <label for="status" class="form-label pt-1 fs-6">{{ __('users.price_change') }}</label>
                                <div class="fw-bold">
                                    <input type="checkbox" class="" data-toggle="toggle" data-onstyle="success" name="change_price"
                                        data-offstyle="danger"  data-width="100" data-on="{{ __('users.Yes') }}" data-off="{{ __('users.NO') }}">
                                </div>
                            </div>
                        </div>
                        <!-- save button row included below -->
                        @include('pages.table-footer', ['link' => 'customer.index'])
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
function hello(){
    if($("#user_type").val()=='employee'){
        $("#pricenable").show();
    }else{
        $("#pricenable").hide();
    }
    
}
</script>
@endsection
