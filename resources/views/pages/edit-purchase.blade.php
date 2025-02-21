@extends('layouts.master')

@section('title')
{{ __('purchases.Edit_Purchase') }}
@endsection

@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('purchases.Edit_Purchase') }}</h4>
                </div>
            </div>
            <hr>
            <div class="row p-3">
                <div class="shadow-css">
                    @include('message')
                    <form method="POST" action="{{route('purchase.update',$purchase->id)}}" enctype="">
                        @method('patch')
                        @csrf
                        <div class="row mt-3">
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="user_id" class="form-label fs-6">{{ __('purchases.Vendor') }} <span id="customer_amount"></span></label>
                                <select class="form-select mb-2 border-dark @error('user_id') is-invalid @enderror" onchange="getAmount('vendor')" name="user_id" id="user_id" autocomplete="user_id" required>
                                    {{-- <option>{{ __('purchases.Choose')}}</option> --}}
                                    @foreach ($vendors as $vendor)
                                        <option value="{{$vendor->id}}" @selected($vendor->id == $purchase->user_id) >{{$vendor->name}}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 pt-1">
                                <label for="product_id" class="form-label fs-6">{{ __('purchases.Product') }}</label>
                                <select
                                    class="form-select mb-2 border-dark @error('product_id') is-invalid @enderror"
                                    name="product_id__" id="product_id__" autocomplete="product_id__" required disabled>
                                    @php
                                        $product_id= '';
                                    @endphp
                                    @foreach ($products as $product)
                                        @if($purchase->name==$product->name)
                                        @php
                                            $product_id = $product->id;
                                        @endphp
                                        @endif
                                        <option value="{{$product->id}}" @selected($purchase->name==$product->name)>{{$product->name}} @if($product->variation)(<span class="badge bg-info text-dark">{{$product->variation}}</span>) @endif</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <input type="hidden" name="product_id" id="product_id" value="{{$product_id}}">

                            {{-- <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="Name" class="form-label fs-6">{{ __('purchases.Name') }}</label>
                                <input type="text"
                                    class="form-control mb-2 border-dark @error('Name') is-invalid @enderror"
                                    id="Name" name="name" value="{{ old('Name',$purchase->name) }}"
                                    autocomplete="Name" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="qty" class="form-label fs-6">{{ __('purchases.Quantity') }}</label>
                                <input type="text" min="0"
                                    class="form-control mb-2 border-dark @error('qty') is-invalid @enderror"
                                    id="qty" name="qty"  value="{{ old('qty',$purchase->qty) }}"
                                    autocomplete="qty" required autofocus>
                                @error('qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="price" class="form-label fs-6">{{ __('purchases.Cost_Price') }}</label>
                                <input type="text" min="0"
                                    class="form-control mb-2 border-dark @error('price') is-invalid @enderror"
                                    id="price" name="price"  value="{{ old('price',$purchase->price) }}"
                                    autocomplete="price" required autofocus>
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="sale_price" class="form-label fs-6">{{ __('purchases.Sale_Price') }}</label>
                                <input type="text" min="0"
                                    class="form-control mb-2 border-dark @error('sale_price') is-invalid @enderror"
                                    id="sale_price" name="sale_price"  value="{{ old('sale_price',$purchase->sale_price) }}"
                                    autocomplete="sale_price" required autofocus>
                                @error('sale_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="paid_price" class="form-label fs-6">{{ __('purchases.Paid_Price') }}</label>
                                <input type="text" min="0"
                                    class="form-control mb-2 border-dark @error('paid_price') is-invalid @enderror"
                                    id="paid_price" name="paid_amount" value="{{ old('paid_amount',$purchase->paid_amount) }}" @if(placeholderVisible()) placeholder={{ __('999') }}@endif value="{{ old('paid_price') }}"
                                    autocomplete="paid_price" required autofocus>
                                @error('paid_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- save button row included below -->
                        @include('pages.table-footer',['link'=>'purchase.index'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
