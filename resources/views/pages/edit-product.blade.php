@extends('layouts.master')

@section('title')
    {{ __('products.Edit_Product') }}
@endsection

@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('products.Edit_Product') }}</h4>
                </div>
            </div>
            <hr>
            <div class="row p-3">
                <div class="shadow-css">
                    @include('message')
                    <form method="POST" action="{{route('product.update',$product->id)}}" enctype="multipart/form-data">
                        @method('patch')
                        @csrf

                        {{-- @dd($errors->all()); --}}
                        <div class="row mt-3">
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="product_code" class="form-label fs-6">{{ __('products.product_code') }}</label>
                                <input type="number"
                                    class="form-control mb-2 border-dark @error('product_code') is-invalid @enderror" id="product_code"
                                    name="product_code" @if(placeholderVisible()) placeholder={{ __('products.product_code')}}@endif value="{{ old('product_code',$product->product_code) }}" autocomplete="product_code"
                                    >
                                @error('product_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="name" class="form-label fs-6">{{ __('products.Name') }}</label>
                                <input type="text"
                                    class="form-control mb-2 border-dark @error('name') is-invalid @enderror"
                                    id="name" name="name"  value="{{ old('name',$product->name) }}"
                                    autocomplete="name" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="variation" class="form-label fs-6">{{ __('products.Product_Variation') }}</label>
                                <input type="text"
                                    class="form-control mb-2 border-dark @error('variation') is-invalid @enderror" id="variation"
                                    name="variation" placeholder="variation" value="{{ old('variation',$product->variation) }}" autocomplete="variation"
                                     autofocus>
                                @error('variation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="unit" class="form-label fs-6">{{ __('sales.Unit') }}</label>
                                <select
                                    class="form-select mb-2 border-dark @error('unit') is-invalid @enderror"
                                    name="unit" id="unit" autocomplete="unit" >
                                    <option value="kg" @if (old('unit', $product->unit) == 'kg') selected @endif>{{ __('sales.Kilogram')}}</option>
                                    <option value="g" @if (old('unit', $product->unit) == 'g') selected @endif>{{ __('sales.Gram')}}</option>
                                    <option value="L" @if (old('unit', $product->unit) == 'L') selected @endif>{{ __('sales.Liter')}}</option>
                                    <option value="mL" @if (old('unit', $product->unit) == 'mL') selected @endif>{{ __('sales.Milliliter')}}</option>
                                    <option value="pc" @if (old('unit', $product->unit) == 'pc') selected @endif>{{ __('sales.Piece')}}</option>
                                    <option value="pk" @if (old('unit', $product->unit) == 'pk') selected @endif>{{ __('sales.Pack')}}</option>
                                    <option value="unit" @if (old('unit', $product->unit) == 'unit') selected @endif>{{ __('sales.Unit')}}</option>
                                    <option value="lb" @if (old('unit', $product->unit) == 'lb') selected @endif>{{ __('sales.Pound')}}</option>

                                </select>
                                @error('unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="price" class="form-label fs-6">{{ __('products.Cost_Price') }}</label>
                                <input type="text" min="0"
                                    class="form-control mb-2 border-dark @error('price') is-invalid @enderror"
                                    id="price" name="price"  value="{{ old('price',$product->price) }}"
                                    autocomplete="price" required autofocus>
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="sale_price" class="form-label fs-6">{{ __('products.Sale_Price') }}</label>
                                <input type="text" min="0"
                                    class="form-control mb-2 border-dark @error('sale_price') is-invalid @enderror"
                                    id="sale_price" name="sale_price" value="{{ old('sale_price',$product->sale_price) }}"
                                    autocomplete="sale_price" required autofocus>
                                @error('sale_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="stock_alert" class="form-label fs-6">{{ __('products.Stock_Alert') }}</label>
                                <input type="text" min="0"
                                    class="form-control mb-2 border-dark @error('stock_alert') is-invalid @enderror"
                                    id="stock_alert" name="stock_alert" value="{{ old('stock_alert',$product->stock_alert) }}"
                                    autocomplete="stock_alert" required autofocus>
                                @error('stock_alert')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-lg-4 col-md-6 col-12 pt-1 d-flex">
                                <div class="">
                                    <label for="image" class="form-label fs-6">{{ __('products.Image') }}</label>
                                     <input type="file" id="imageInput" class="form-control  mb-2 border-dark" name="image" >
                                    {{-- <input type="file" class="" name="image" /> --}}
                                   @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                </div>
                                
                                <img id="previewImage" src="{{ asset('storage/' . $product->image) }}" class="rounded-pill mt-1 ms-3 border border-3" style="height: 60px; width: 60px !important" alt="Uploaded Image">

                
                            </div>
                        </div>
                        <!-- save button row included below -->
                        @include('pages.table-footer',['link'=>'product.index'])
                    </form>
                  
                </div>
            </div>
        </div>
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