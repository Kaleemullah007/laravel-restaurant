@extends('layouts.master')

@section('title')
    {{ __('deposits.Create_Deposit') }}
@endsection

@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('deposits.Create_Deposit') }}</h4>
                </div>
            </div>
            <hr>
            <div class="row p-3">
                <div class="shadow-css">
                    @include('message')
                    <form method="POST" action="{{route('deposit.store')}}" enctype="">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="amount" class="form-label fs-6">{{ __('deposits.Amount') }}</label>
                                <input type="text" min="0"
                                    class="form-control mb-2 border-dark @error('amount') is-invalid @enderror"
                                    id="amount" name="amount" @if(placeholderVisible()) placeholder={{ __('200')}}@endif value="{{ old('amount') }}"
                                    autocomplete="amount" required autofocus>
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="Description" class="form-label fs-6">{{ __('deposits.Description') }}</label>
                                <textarea
                                    class="form-control mb-2 border-dark @error('description') is-invalid @enderror"
                                    id="description" name="description" @if(placeholderVisible()) placeholder={{ __('deposits.Description')}}@endif
                                    autocomplete="description" autofocus>{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="date" class="form-label fs-6">{{ __('deposits.Customer') }}</label>
                                <select
                                    class="form-control mb-2 select2 border-dark @error('user_id') is-invalid @enderror"
                                    id="user_id" name="user_id" value="{{ old('user_id') }}"
                                    autocomplete="user_id" required autofocus  onchange="getDeposit()">
                                    @foreach ($customers as $cus )
                                    <option value="{{$cus->id}}" @selected($cus->id == $customer->id)>{{$cus->name}}</option>

                                    @endforeach
                                </select>

                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- save button row included below -->
                        @include('pages.table-footer',['link'=>'customer.index'])
                    </form>
                    <div id="searchable">
                    @include('pages.ajax-deposit')
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
