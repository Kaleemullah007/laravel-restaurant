@extends('layouts.master')

@section('title')
    Sales Listing
@endsection
<style>
    .select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid black !important;
    border-radius: 6px;
    height: 39px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered 
    {
        color: #444;
        line-height: 35px !important;
    }

</style>
@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('en.Sales') }}</h4>
                </div>
            </div>
            <hr>
            <div class="row my-4">
                <div class="col-lg-3 col-md-6 col-12 mt-2 d-flex">
                    <label for="search" class="form-label mt-1"><i class="bi bi-search fs-4"></i></label>
                    <input type="text" onkeyup="getSales()"
                        class="form-control form-control-css border-secondary ms-3 rounded"
                        placeholder="{{ __('en.Search this table...') }}" id="search">
                </div>
                <div class="col-lg-3 col-md-6 col-12 mt-2 d-flex">
                    <select class="form-select border-dark select2 @error('customer_id') is-invalid @enderror"
                        onchange="getSales()" name="customer_id" id="customer_id" autocomplete="customer_id" required>
                        <option>{{ __('en.Choose Customer') }}</option>
                        @isset($customers)
                        @php
                              $customer_id  =  request('customer_id')??null;
                        @endphp
                        @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" @selected($customer_id==$customer->id)  >{{ $customer->name }}</option>
                            @endforeach    
                        @endisset
                        
                    </select>
                    @error('customer_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-lg-3 col-md-6 col-12 mt-2 d-flex">
                    @include('pages.list-filter', ['functionName' => 'getSales'])
                </div>

                <div class="col-lg-3 col-md-6 col-12 mt-2 text-end">
                    <!-- offcanvas trigger for filter -->
                    {{-- <button type="button" class="btn btn-sm me-2 btn-outline-primary" data-bs-toggle="offcanvas"
                        data-bs-target="#filters" aria-controls="filters"><i class="bi bi-funnel"></i> {{__('en.Filter')}}</button>
                    <button type="button" class="btn btn-sm me-2 btn-outline-success"><i class="bi bi-filetype-pdf"></i>
                        {{__('en.PDF')}}</button> --}}
                    {{-- <button type="button" class="btn btn-sm me-2 btn-outline-danger export-csv-sale"><i
                            class="bi bi-file-earmark-excel-fill"></i> {{ __('en.EXCEL') }}</button> --}}
                    <!-- modal trigger for create sale -->
                    <a href="{{ route('sale.create') }}" class="btn btn-sm me-2 btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>{{ __('en.Create') }}</a>
                </div>
            </div>
            <div class="table-responsive " id="searchable">
                @include('pages.ajax-sale', ['sales' => $sales])
            </div>

            {{-- row per page and pagination file below --}}
            @include('pages.pagination', ['paginate' => $sales])



        </div>
    </div>
@endsection
