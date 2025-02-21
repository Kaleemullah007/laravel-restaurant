@extends('layouts.master')

@section('title')
    {{ __('expenses.Create_Expense') }}
@endsection

@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('expenses.Create_Expense') }}</h4>
                </div>
            </div>
            <hr>
            <div class="row p-3">
                <div class="shadow-css">
                    @include('message')
                    <form method="POST" action="{{route('expense.store')}}" enctype="">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="name" class="form-label fs-6">{{ __('expenses.Name') }}</label>
                                <input type="text"
                                    class="form-control mb-2 border-dark @error('name') is-invalid @enderror"
                                    id="name" name="name" @if(placeholderVisible()) placeholder={{ __('expenses.Name')}}@endif value="{{ old('name') }}"
                                    autocomplete="name" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="amount" class="form-label fs-6">{{ __('expenses.Amount') }}</label>
                                <input type="text" min="0"
                                    class="form-control mb-2 border-dark @error('amount') is-invalid @enderror"
                                    id="amount" name="amount" @if(placeholderVisible()) placeholder={{ __('500')}}@endif value="{{ old('amount') }}"
                                    autocomplete="amount" required autofocus>
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="date" class="form-label fs-6">{{ __('expenses.Date') }}</label>
                                <input type="date"
                                    class="form-control mb-2 border-dark @error('date') is-invalid @enderror"
                                    id="date" name="date" value="{{ old('date') }}"
                                    autocomplete="date" required autofocus>
                                @error('date')
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
