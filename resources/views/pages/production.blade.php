@extends('layouts.master')

@section('title')
    Production Listing
@endsection
@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('en.Productions') }}</h4>
                </div>
            </div>
            <hr>
            <div class="row my-4">
                <div class="col-lg-3 col-md-6 col-12 mt-2 d-flex">
                    <label for="search" class="form-label mt-1"><i class="bi bi-search fs-4"></i></label>
                    <input type="text" class="form-control form-control-css border-secondary ms-3 rounded"
                        placeholder="{{ __('en.Search this table...') }}" id="search" onkeyup="getProductions()">
                </div>
                <div class="col-lg-6 col-md-6 col-12 mt-2 d-flex">
                    @include('pages.list-filter',['functionName'=>'getProductions'])
                </div>

                <div class="col-lg-3 col-md-6 col-12 mt-2 text-end">
                    {{-- <button type="button" class="btn btn-sm export-csv-production me-2 btn-outline-danger"><i
                            class="bi bi-file-earmark-excel-fill"></i> {{ __('en.EXCEL') }}</button> --}}
                    <!-- modal trigger for create production -->
                    <a href="{{ route('production.create') }}" class="btn btn-sm me-2 btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>{{ __('en.Create') }}</a>
                </div>
            </div>
            <div class="table-responsive" id="searchable">
                @include('pages.ajax-production',['productions'=>$productions])
            </div>
            {{-- row per page and pagination file below --}}
            @include('pages.pagination', ['paginate' => $productions])

        </div>
    </div>
@endsection
