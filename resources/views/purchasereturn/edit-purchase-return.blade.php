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
                    <form method="POST" action="{{route('purchase-return.update',$purchaseReturn->id)}}" enctype="">
                        @method('put')
                        @csrf
                        <div class="row mt-3">
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <input type="hidden" name="page" value="{{request('page',1)}}">
                                <label for="user_id" class="form-label fs-6">{{ __('purchases.Vendor') }} <span id="customer_amount"></span></label>
                                <select class="form-select mb-2 border-dark @error('user_id') is-invalid @enderror" onchange="getAmount('vendor')" name="user_id" id="user_id" autocomplete="user_id" required>
                                    
                                    @foreach ($vendors as $vendor)
                                        <option value="{{$vendor->id}}" @selected($vendor->vendor->id == $purchaseReturn->user_id) >{{$vendor->vendor->name}}</option>
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
                                    
                                    
                                        <option value="{{$purchaseReturn->product_id}}" selected>{{$purchaseReturn->product_name}}</option>
                                 
                                </select>
                                @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <input type="hidden" name="product_id" id="product_id" value="{{$purchaseReturn->product_id}}">

                           
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="qty" class="form-label fs-6">{{ __('purchases.Quantity') }}</label>
                                <input type="text" min="0"
                                    class="form-control mb-2 border-dark @error('qty') is-invalid @enderror"
                                    id="qty" name="qty"  value="{{ old('qty',$purchaseReturn->quantity) }}"
                                    autocomplete="qty" required autofocus>
                                @error('qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="price" class="form-label fs-6">{{ __('purchases.Cost_Price') }} <span class="current_price">{{$purchaseReturn->unit_price}}</span></label>
                                <input type="text" min="0"
                                    class="form-control mb-2 border-dark @error('price') is-invalid @enderror"
                                    id="price" name="price"  value="{{ old('price',$purchaseReturn->unit_price) }}"
                                    autocomplete="price" required autofocus>
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-4">
                                <label for="price" class="form-label fs-6"> <span class="current_price"></span></label>
                                <input type="checkbox" class="py-0 w-full" name="is_edit" id="is_edit" data-toggle="toggle" data-on="Returned"
                                data-off="Not Returned" data-onstyle="success" data-offstyle="danger" >
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                                @error('price')
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
