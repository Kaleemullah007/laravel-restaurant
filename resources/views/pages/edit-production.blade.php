@extends('layouts.master')

@section('title')
    Edit Production
@endsection

@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('en.Edit Production') }}</h4>
                </div>
            </div>
            <hr>
            <div class="row p-3">
                <div class="shadow-css">
                    @include('message')
                    <form method="POST" action="{{route('production.update',$production->id)}}" enctype="">
                        @method('patch')
                        @csrf
                        <div class="row mt-3">
                            <div class="col-lg-3 col-md-6 col-12 pt-1">
                                <label for="purchase_id" class="form-label  fs-6">{{ __('en.Raw Material') }}</label>
                                <select
                                    class="form-select mb-2 border-dark select2 @error('purchase_id') is-invalid @enderror"
                                    name="purchase_id" id="purchase_id" autocomplete="purchase_id" required>
                                    <option>{{ __('en.Choose') }}</option>
                                    @foreach ($raws as $raw)
                                            <option value="{{$raw->id}}" @selected($raw->id == $production->purchase_id)>{{$raw->name}}</option>
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
                                    <option>{{ __('en.Choose') }}</option>
                                    @foreach ($products as $product)    
                                        <option value="{{$product->id}}" @selected($product->id == $production->product_id)>{{$product->name}}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 pt-1">
                                <label for="qty" class="form-label fs-6">{{ __('en.Quantity') }}</label>
                                <input type="number" min="1"
                                    class="form-control mb-2 border-dark @error('qty') is-invalid @enderror"
                                    id="qty" name="qty" value="{{ old('qty',$production->qty) }}"
                                    autocomplete="qty" required autofocus>
                                @error('qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 pt-1">
                                <label for="wastage_qty" class="form-label fs-6">{{ __('en.Waste') }}</label>
                                <input type="number" min="0"
                                    class="form-control mb-2 border-dark @error('wastage_qty') is-invalid @enderror"
                                    id="wastage_qty" name="wastage_qty" value="{{ old('wastage_qty',$production->wastage_qty) }}"
                                    autocomplete="wastage_qty" required autofocus>
                                @error('wastage_qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- save button row included below -->
                        @include('pages.table-footer',['link'=>'production.index'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
