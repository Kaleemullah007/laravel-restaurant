@extends('layouts.master')

@section('title')
{{ __('purchases.Create_Purchase') }}
@endsection

@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('purchases.Create_Purchase') }}</h4>
                </div>
            </div>
            <hr>
            <div class="row p-3">
                <div class="shadow-css">
                    {{-- @dd($errors->all()); --}}
                    @include('message')
                    <form method="POST" action="{{ route('purchase.store') }}" enctype="">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="user_id" class="form-label  fs-6">{{ __('purchases.Vendor') }}<span id="customer_amount"></span></label>
                                <div class="input-group input-group-md d-flex">
                                    <select
                                        class="form-select mb-2 border-dark select2 @error('user_id') is-invalid @enderror"
                                        name="user_id" id="user_id" autocomplete="user_id" onchange="getAmount('vendor')" required>
                                        <option>{{ __('purchases.Choose') }}</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <!-- Button trigger for add vendor -->
                                    <span class=" mb-2 ps-2" data-bs-toggle="modal" data-bs-target="#add_vendor"><i
                                            class="bi fs-4 bi-person-plus-fill"></i></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="product_id" class="form-label fs-6">{{ __('purchases.Product') }}</label>
                                <div class="input-group input-group-md d-flex">
                                    <select
                                        class="form-select mb-2 selcet2 border-dark @error('product_id') is-invalid @enderror"
                                        name="product_id" id="product_id" autocomplete="product_id" required>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }} @if($product->variation)(<span class="badge bg-info text-dark">{{$product->variation}}</span>) @endif</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <a class=" mb-2 ps-2 link-dark" href="{{ route('product.create', ['id' => 1]) }}"><i
                                            class="bi fs-4 bi-file-plus"></i></a>
                                    {{-- <a class=" mb-2 ps-2 bg-secondary"
                                        href="{{ route('product.create', ['id' => 1]) }}"><span><i
                                                class="bi fs-4 bi-person-plus-fill"></i></span></a> --}}
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="qty" class="form-label fs-6">{{ __('purchases.Quantity') }}</label>
                                <input type="text" min="1"
                                    class="form-control mb-2 border-dark @error('qty') is-invalid @enderror" id="qty"
                                    name="qty"@if(placeholderVisible()) placeholder={{ __('purchases.Quantity') }}@endif value="{{ old('qty') }}" autocomplete="qty" required
                                    autofocus>
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
                                    id="price" name="price"  @if(placeholderVisible()) placeholder={{ __('499') }}@endif value="{{ old('price') }}"
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
                                    id="sale_price" name="sale_price" @if(placeholderVisible()) placeholder={{ __('999') }}@endif value="{{ old('sale_price') }}"
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
                                    id="paid_price" name="paid_amount" @if(placeholderVisible()) placeholder={{ __('999') }}@endif value="{{ old('paid_price') }}"
                                    autocomplete="paid_price" required autofocus>
                                @error('paid_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- save button row included below -->
                        @include('pages.table-footer', ['link' => 'purchase.index'])
                    </form>


                    <!-- Modal itself for add Vendor -->
                    <div class="modal fade" id="add_vendor" tabindex="-1" aria-labelledby="add_vendorLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form method="POST" action="" enctype="" id="FormDataVendor">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="add_vendorLabel">{{ __('purchases.Add_Vendor') }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="first_name" class="form-label fs-6">{{ __('purchases.First_Name') }}</label>
                                        <input type="text"
                                            class="form-control mb-2 border-dark @error('first_name') is-invalid @enderror"
                                            id="first_name" name="first_name" @if(placeholderVisible()) placeholder={{ __('purchases.First_Name') }}@endif 
                                            value="{{ old('first_name') }}" autocomplete="first_name" required autofocus>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="last_name" class="form-label fs-6">{{ __('purchases.Last_Name') }}</label>
                                        <input type="text"
                                            class="form-control mb-2 border-dark @error('last_name') is-invalid @enderror"
                                            id="last_name" name="last_name" @if(placeholderVisible()) placeholder={{ __('purchases.Last_Name') }}@endif
                                            value="{{ old('last_name') }}" autocomplete="last_name" required autofocus>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="phone" class="form-label fs-6">{{ __('purchases.Phone') }}</label>
                                        <input type="phone"
                                            class="form-control mb-2 border-dark @error('phone') is-invalid @enderror"
                                            id="phone" name="phone"  @if(placeholderVisible()) placeholder={{ __('+923001234567') }}@endif                                        value="{{ old('phone') }}" autocomplete="phone" required autofocus>
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="email" class="form-label fs-6">{{ __('purchases.Email') }}</label>
                                        <input type="email"
                                            class="form-control mb-2 border-dark @error('email') is-invalid @enderror"
                                            id="email" name="email"  @if(placeholderVisible()) placeholder={{ __('ABC123@example.com') }}@endif
                                            value="{{ old('email') }}" autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="modal-footer">
                                        <!-- save button row included below -->
                                        @include('pages.modal-footer')
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    
    $(document).on("keyup","#qty, #price",function(){
        let qty  = $("#qty").val() || 1;
        let price  = $("#price").val() || 0;

        let totalPrice=  parseFloat(qty) * parseFloat(price);
        $("#paid_price").val(totalPrice);

    })

</script>
@endsection
