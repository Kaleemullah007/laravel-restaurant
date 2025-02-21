@extends('layouts.master')

@section('title')
{{ __('deposits.Edit_Deposit') }}
@endsection

@section('content')
    <div class="container">
        <div class="container">
            <div class="row d-flex">
                <div class="col-6">
                    <h4>{{ __('deposits.Edit_Deposit') }}</h4>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <a class="btn btn-md btn btn-secondary" href="{{route("customer.show",$deposit->user_id)}}">{{ __('deposits.Back') }}</a>
                </div>

            </div>
            <hr>
            <div class="row p-3">

                <div class="shadow-css">
                    @include('message')
                    <form method="POST" action="{{route('deposit.update',$deposit->id)}}" enctype="">
                        @method('patch')
                        @csrf
                        <div class="row mt-3">
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="amount" class="form-label fs-6">{{ __('deposits.Amount') }}</label>
                                <input type="text" min="0"
                                    class="form-control mb-2 border-dark @error('amount') is-invalid @enderror"
                                    id="amount" name="amount" placeholder="20" value="{{ old('amount',$deposit->amount) }}"
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
                                    id="description" name="description" placeholder="description"
                                    autocomplete="description" autofocus>{{ old('description',$deposit->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="date" class="form-label fs-6">{{ __('deposits.Customer') }}</label>
                                <select disabled
                                    class="form-control mb-2 select2 border-dark @error('user_id') is-invalid @enderror"
                                    id="user_id" name="user_id" value="{{ old('user_id') }}"
                                    autocomplete="user_id" required autofocus>
                                    @foreach ($customers as $cus )
                                    <option value="{{$cus->id}}" @selected($deposit->user_id == $cus->id)>{{$cus->name}}</option>

                                    @endforeach
                                </select>
                                <input type="hidden" name="user_id" value="{{$deposit->user_id}}">

                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- save button row included below -->
                        @include('pages.table-footer',['link'=>'expense.index'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
