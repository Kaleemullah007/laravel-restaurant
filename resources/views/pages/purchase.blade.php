@extends('layouts.master')

@section('title')
    Purchase Listing
@endsection
@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('en.Purchases') }}</h4>
                </div>
            </div>
            <hr>
            <div class="row my-4">
                <div class="col-lg-3 col-md-6 col-12 mt-2 d-flex">
                    <label for="search" class="form-label mt-1"><i class="bi bi-search fs-4"></i></label>
                    <input type="text" class="form-control form-control-css border-secondary ms-3 rounded"
                        placeholder="{{ __('en.Search this table...') }}" id="search" onkeyup="getPurchases()">
                </div>

                <div class="col-lg-6 col-md-6 col-12 mt-2 d-flex">
                    @include('pages.list-filter',['functionName'=>'getPurchases'])
                </div>
                <div class="col-lg-3 col-md-6 col-12 mt-2 text-end">
                    {{-- <button type="button" class="btn btn-sm export-csv-purchase me-2 btn-outline-danger"><i
                            class="bi bi-file-earmark-excel-fill"></i> {{ __('en.EXCEL') }}</button> --}}
                    <!-- modal trigger for create sale -->
                    <a href="{{ route('purchase.create') }}" class="btn btn-sm me-2 btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>{{ __('en.Create') }}</a>
                </div>
            </div>
            <div class="table-responsive" id="searchable">
                @include('pages.ajax-purchase',['purchases'=>$purchases])
            </div>


            <!-- Modal -->
            {{-- <div class="modal fade" id="process_product" tabindex="-1" aria-labelledby="process_productLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="POST" action="" enctype="">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="process_productLabel">Add Production</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="is_production" class="form-label fs-6 mt-1">{{__('en.Production Status')}}</label>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <input type="checkbox" checked name="is_production" id="is_production" data-width="75" data-size="sm" data-toggle="toggle" data-on="Active"
                                        data-off="Inactive" data-onstyle="success" data-offstyle="danger">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="qty" class="form-label fs-6 mt-1">{{__('en.Production Quantity')}}</label>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <input type="number" class="form-control border-dark @error('qty') is-invalid @enderror" id="qty" name="qty"
                                        placeholder="10" value="{{ old('qty') }}" autocomplete="qty" required autofocus>
                                        @error('qty')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="is_wastage" class="form-label fs-6 mt-1">{{__('en.Wastage Status')}}</label>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <input type="checkbox" checked name="is_wastage" id="is_wastage" data-width="75" data-size="sm" data-toggle="toggle" data-on="Active"
                                        data-off="Inactive" data-onstyle="success" data-offstyle="danger">
                                    </div>
                                    <div class="col-6 ">
                                        <label for="wastage_qty" class="form-label fs-6 mt-1">{{__('en.Wastage Quantity')}}</label>
                                    </div>
                                    <div class="col-6 ">
                                        <input type="number" class="form-control border-dark @error('wastage_qty') is-invalid @enderror" id="wastage_qty" name="wastage_qty"
                                        placeholder="10" value="{{ old('wastage_qty') }}" autocomplete="wastage_qty" required autofocus>
                                        @error('wastage_qty')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <!-- save button row included below -->
                                @include('pages.modal-footer')
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}
            {{-- row per page and pagination file below --}}
            @include('pages.pagination', ['paginate' => $purchases])

        </div>
    </div>
@endsection
