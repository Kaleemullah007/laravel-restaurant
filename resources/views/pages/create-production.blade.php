@extends('layouts.master')

@section('title')
    Create Production
@endsection

@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('en.Create Production') }}</h4>
                </div>
            </div>
            <hr>
            <div class="row p-3">
                <div class="shadow-css">
                 @include('message')
                    <form method="POST" action="{{ route('production.store') }}" enctype="">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-lg-3 col-md-6 col-12 pt-1">
                                <label for="raw" class="form-label  fs-6">{{ __('en.Raw Material') }}</label>
                                <select
                                    class="form-select mb-2 border-dark select2 @error('purchase_id') is-invalid @enderror"
                                    name="purchase_id" id="purchase_id" autocomplete="purchase_id" required>
                                 
                                    @foreach ($raws as $raw)
                                            <option value="{{$raw->id}}">{{$raw->name}}</option>
                                        @endforeach
                                </select>
                                @error('purchase_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 pt-1">
                                <label for="product_id" class="form-label fs-6">{{ __('en.Product') }}</label>
                                <select
                                    class="form-select mb-2 border-dark @error('product_id') is-invalid @enderror"
                                    name="product_id" id="product_id" autocomplete="product_id" required>
                                    @foreach ($products as $product)    
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-4 col-12 pt-1">
                                <label for="qty" class="form-label fs-6">{{ __('en.Quantity') }}</label>
                                <input type="number" min="1"
                                    class="form-control mb-2 border-dark @error('qty') is-invalid @enderror"
                                    id="qty" name="qty" value="{{ old('qty') }}"
                                    autocomplete="qty" required autofocus>
                                @error('qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-4 col-12 pt-1">
                                <label for="wastage_qty" class="form-label fs-6">{{ __('en.Waste') }}</label>
                                <input type="number" min="0"
                                    class="form-control mb-2 border-dark @error('wastage_qty') is-invalid @enderror"
                                    id="wastage_qty" name="wastage_qty" value="{{ old('wastage_qty') }}"
                                    autocomplete="wastage_qty" required autofocus>
                                @error('wastage_qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- save button row included below -->
                        @include('pages.table-footer', ['link' => 'production.index'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
