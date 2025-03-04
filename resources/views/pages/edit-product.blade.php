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
                        <div class="col-sm-4 ps-0">
                            <input type="checkbox" class="py-0" name="is_product" id="is_product" data-toggle="toggle"
                                data-on="Product" data-off="Deal" data-onstyle="info" data-offstyle="primary"
                                @if(old('is_product_value',$product->is_deal)==1) checked @endif >
                            <input type="hidden" name="is_product_value" id="is_product_value"
                                value="{{old('is_product_value',$product->is_deal)}}">
                        </div>
                        <div class="product_section" @if(old('is_product_value',$product->is_deal)==0) style="display: none"
                            @endif >
                        <div class="row mt-3">
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="product_code" class="form-label fs-6">{{ __('products.product_code')
                                    }}</label>
                                <input type="number"
                                    class="form-control mb-2 border-dark @error('product_code') is-invalid @enderror"
                                    id="product_code" name="product_code" @if(placeholderVisible()) placeholder={{
                                    __('products.product_code')}}@endif
                                    value="{{ old('product_code',$product->product_code) }}"
                                    autocomplete="product_code">
                                @error('product_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="name" class="form-label fs-6">{{ __('products.Name') }}</label>
                                <input type="text"
                                    class="form-control mb-2 border-dark @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name',$product->name) }}" autocomplete="name" required
                                    autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="variation" class="form-label fs-6">{{ __('products.Product_Variation')
                                    }}</label>
                                <input type="text"
                                    class="form-control mb-2 border-dark @error('variation') is-invalid @enderror"
                                    id="variation" name="variation" placeholder="variation"
                                    value="{{ old('variation',$product->variation) }}" autocomplete="variation"
                                    autofocus>
                                @error('variation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="unit" class="form-label fs-6">{{ __('sales.Unit') }}</label>
                                <select class="form-select mb-2 border-dark @error('unit') is-invalid @enderror"
                                    name="unit" id="unit" autocomplete="unit">
                                    <option value="kg" @if (old('unit', $product->unit) == 'kg') selected @endif>{{
                                        __('sales.Kilogram')}}</option>
                                    <option value="g" @if (old('unit', $product->unit) == 'g') selected @endif>{{
                                        __('sales.Gram')}}</option>
                                    <option value="L" @if (old('unit', $product->unit) == 'L') selected @endif>{{
                                        __('sales.Liter')}}</option>
                                    <option value="mL" @if (old('unit', $product->unit) == 'mL') selected @endif>{{
                                        __('sales.Milliliter')}}</option>
                                    <option value="pc" @if (old('unit', $product->unit) == 'pc') selected @endif>{{
                                        __('sales.Piece')}}</option>
                                    <option value="pk" @if (old('unit', $product->unit) == 'pk') selected @endif>{{
                                        __('sales.Pack')}}</option>
                                    <option value="unit" @if (old('unit', $product->unit) == 'unit') selected @endif>{{
                                        __('sales.Unit')}}</option>
                                    <option value="lb" @if (old('unit', $product->unit) == 'lb') selected @endif>{{
                                        __('sales.Pound')}}</option>

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
                                    id="price" name="price" value="{{ old('price',$product->price) }}"
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
                                    id="sale_price" name="sale_price"
                                    value="{{ old('sale_price',$product->sale_price) }}" autocomplete="sale_price"
                                    required autofocus>
                                @error('sale_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="stock_alert" class="form-label fs-6">{{ __('products.Stock_Alert')
                                    }}</label>
                                <input type="text" min="0"
                                    class="form-control mb-2 border-dark @error('stock_alert') is-invalid @enderror"
                                    id="stock_alert" name="stock_alert"
                                    value="{{ old('stock_alert',$product->stock_alert) }}" autocomplete="stock_alert"
                                    required autofocus>
                                @error('stock_alert')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6 col-12 pt-1 d-flex">
                                <div class="">
                                    <label for="image" class="form-label fs-6">{{ __('products.Image') }}</label>
                                    <input type="file" id="imageInput" class="form-control  mb-2 border-dark"
                                        name="image">
                                    {{-- <input type="file" class="" name="image" /> --}}
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>

                                <img id="previewImage" src="{{ asset('storage/' . $product->image) }}"
                                    class="rounded-pill mt-1 ms-3 border border-3"
                                    style="height: 60px; width: 60px !important" alt="Uploaded Image">
                            </div>
                            <input type="checkbox" class="py-0" name="is_stock_manageable" id="is_stock_manageable" data-toggle="toggle" data-on="Stock Manageable"
                            data-off="Not Stock Manageable" data-onstyle="info" data-offstyle="primary"  @if(old('is_stock_manageable',$product->is_stock_manageable)==1) checked @endif  >

                        </div>
                        </div>
                           {{-- Deals --}}

                <div class="deal_section hide" @if(old('is_product_value',$product->is_deal)==1) style="display: none"
                    @endif >
                    <div class="row mt-3">
                        <!-- Name of Deal -->
                        <div class="col-lg-4 col-md-6 col-12 pt-1">
                            <label for="deal_name" class="form-label fs-6">{{ __('deals.Deal_Name') }}</label>
                            <input type="text"
                                class="form-control mb-2 border-dark @error('deal_name') is-invalid @enderror"
                                id="deal_name" name="deal_name" value="{{ old('deal_name',$product->name) }}"
                                autocomplete="deal_name">
                            @error('deal_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Code of Deal -->
                        <div class="col-lg-4 col-md-6 col-12 pt-1">
                            <label for="deal_code" class="form-label fs-6">{{ __('deals.Deal Code') }}</label>
                            <input type="text"
                                class="form-control mb-2 border-dark @error('deal_code') is-invalid @enderror"
                                id="deal_code" name="deal_code" value="{{ old('deal_code',$product->product_code) }}"
                                autocomplete="deal_code">
                            @error('deal_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Product Dropdown -->
                        <div class="col-lg-4 col-md-6 col-12 pt-1">
                            <label for="product" class="form-label fs-6">{{ __('deals.Product') }}</label>
                            <select class="form-select mb-2 border-dark @error('product_id') is-invalid @enderror"
                                name="product_id" id="product_id">
                                <option value="">{{ __('deals.Select_Product') }}</option>
                                @foreach ($products as $dproduct)
                                <option value="{{ $dproduct->id }}" @selected(old('product_id')==$dproduct->id)>
                                    {{ $dproduct->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('product_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Start Time -->
                        <div class="col-lg-4 col-md-6 col-12 pt-1">
                            <label for="start_time" class="form-label fs-6">{{ __('deals.Start_Time') }}</label>
                            <input type="datetime-local"
                                class="form-control mb-2 border-dark @error('start_time') is-invalid @enderror"
                                id="start_time" name="start_time" value="{{ old('start_time',$product->start_time) }}">
                            @error('start_time')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- End Time -->
                        <div class="col-lg-4 col-md-6 col-12 pt-1">
                            <label for="end_time" class="form-label fs-6">{{ __('deals.End_Time') }}</label>
                            <input type="datetime-local"
                                class="form-control mb-2 border-dark @error('end_time') is-invalid @enderror"
                                id="end_time" name="end_time" value="{{ old('end_time',$product->end_time) }}">
                            @error('end_time')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="col-lg-4 col-md-6 col-12 pt-1">
                            <label for="deal_price" class="form-label fs-6">{{ __('deals.Deal_Price') }}</label>
                            <input type="text"
                                class="form-control mb-2 border-dark @error('deal_price') is-invalid @enderror"
                                id="deal_price" name="deal_price" value="{{ old('deal_price',$product->sale_price) }}">
                            @error('deal_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-lg-4 col-md-6 col-12 pt-1">
                            <label for="status" class="form-label fs-6">{{ __('deals.Status') }}</label>
                            <select class="form-select mb-2 border-dark @error('status') is-invalid @enderror"
                                name="status" id="status">
                                <option value="active" @selected(old('status',$product->status)==1 )>{{
                                    __('deals.Active') }}
                                </option>
                                <option value="inactive" @selected(old('status',$product->status)==0 )>{{
                                    __('deals.Inactive')
                                    }}</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 pt-1 d-flex">
                            <div class="">
                                <label for="image" class="form-label fs-6">{{ __('products.Image') }}</label>
                                <input type="file" id="imageInput" class="form-control mb-2 border-dark" name="image">
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <img id="imageInputDeals" src="{{ asset('/assets/images/no-image.png') }}"
                                class="rounded-pill mt-1 ms-3 border border-3"
                                style="height: 60px; width: 60px !important" alt="Selected Image">
                        </div>
                    </div>
                    <div class="row mt-3" id="selected-product">
                        <div class="col-12">
                            <h5>{{ __('deals.Selected_Product_Details') }} {{ auth()->user()->currency}}<span
                                    class="text-danger" id="total-price"></span> </h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('deals.Product_Name') }}</th>
                                        <th>{{ __('deals.Image') }}</th>
                                        <th>{{ __('deals.Product_Price') }}</th>
                                        <th>{{ __('deals.Qty') }}</th>
                                        <th>{{ __('deals.Swapable') }}</th>
                                        <th>{{ __('deals.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="product-details">

                                    @if(old('productss'))

                                    @foreach(old('productss') as $key => $product)
                                    <tr id="dp-{{$product['product_id']}}" data-id={{$product['product_id']}}>
                                        <td>{{$product['name']}}<input type="hidden"
                                                name="productss[{{$product['product_id']}}][product_id]"
                                                value="{{$product['product_id']}}" id=""></td>

                                        <td>{!! image('', $product['image'], ['class=" border border-1"',
                                            'style="height: 30px; width: 30px !important"']) !!}</td>
                                        <td class="productprice">{{$product['price']}}
                                            <input type="hidden"
                                                name="productss[{{$product['product_id']}}][sale_price]"
                                                value="{{$product['sale_price']}}" id="">
                                            <input type="hidden" name="productss[{{$product['product_id']}}][name]"
                                                value="{{$product['name']}}" id="">
                                            <input type="hidden" name="productss[{{$product['product_id']}}][price]"
                                                value="{{$product['sale_price']}}" id="">
                                            <input type="hidden" name="productss[{{$product['product_id']}}][image]"
                                                value="{{$product['image']}}" id="">
                                        </td>
                                        <td> <input type="number" class="quantity"
                                                name="productss[{{$product['product_id']}}][quantity]"
                                                value="{{$product['quantity']}}"></td>
                                        <td> <input type="checkbox" class="is_swappable"
                                                name="productss[{{$product['product_id']}}][is_swappable]" @if(
                                                isset($product['is_swappable'])) checked @endif></td>
                                        <td onclick="removePRoduct({{$product['product_id']}})">remove</td>
                                    </tr>
                                    @endforeach

                                    @else
                                    @php
                                    $dealsProducts = $product->dealProducts->toArray();

                                    @endphp
                                    @foreach($dealsProducts as $key => $pro)
                                    <tr id="dp-{{$pro['deal_product_id']}}" data-id={{$pro['deal_product_id']}}>
                                        <td>{{$pro['name']}}<input type="hidden"
                                                name="productss[{{$pro['deal_product_id']}}][product_id]"
                                                value="{{$pro['deal_product_id']}}" id=""></td>

                                        <td>{!! image('', $pro['image'], ['class=" border border-1"', 'style="height:
                                            30px; width: 30px !important"']) !!}</td>
                                        <td class="productprice">{{$pro['sprice']}}
                                            <input type="hidden" name="productss[{{$pro['deal_product_id']}}][sale_price]"
                                                value="{{$pro['sale_price']}}" id="">
                                            <input type="hidden" name="productss[{{$pro['deal_product_id']}}][name]"
                                                value="{{$pro['product_name']}}" id="">
                                            <input type="hidden" name="productss[{{$pro['deal_product_id']}}][price]"
                                                value="{{$pro['sale_price']}}" id="">
                                            <input type="hidden" name="productss[{{$pro['deal_product_id']}}][image]"
                                                value="{{$pro['image']}}" id="">
                                        </td>
                                        <td> <input type="number" class="quantity"
                                                name="productss[{{$pro['deal_product_id']}}][quantity]"
                                                value="{{$pro['quantity']}}"></td>
                                        <td> <input type="checkbox" class="is_swappable"
                                                name="productss[{{$pro['deal_product_id']}}][is_swappable]" @if(
                                                isset($pro['is_swappable'])) checked @endif></td>
                                        <td onclick="removePRoduct({{$pro['deal_product_id']}})">remove</td>
                                    </tr>
                                    @endforeach

                                    @endif
                                    {{-- <tr>
                                        <td colspan="5" class="text-center">{{ __('deals.No_Product_Selected') }}</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
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
        updateTotal();
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

        $(document).ready(function(){
        updateTotal();
    });
    function removePRoduct(id){
            $("#dp-"+id).remove();
            updateTotal();
        }
        function updateTotal() {
    let total = 0;
    let  price=0;
    let quantity =1;
    // Loop through each row in the table
    $('#product-details  tr').each(function() {
        
         price = parseFloat($(this).find('.productprice').text()); // Get the product price
         quantity = parseInt($(this).find('.quantity').val()); // Get the product quantity
        
        
        if (!isNaN(price) && !isNaN(quantity)) {
            total += price * quantity; // Add the price * quantity to the total
        }
    });

    // Update the total price in the designated field
    $('#total-price').text(total.toFixed(2)); // Display the total price with 2 decimal places
}


$(document).on('change','.quantity', function () {
    updateTotal();
});
        // Update the selected product details when a product is selected
        $('#product_id').on('change', function () {
            const productId = $(this).val();
            let existingRow = $('#dp-' + productId); // Find row with matching product ID
            if (existingRow.length > 0) {
        // If the product already exists, increment the quantity
        let quantityInput = existingRow.find('.quantity');
        let currentQuantity = parseInt(quantityInput.val()); // Get current quantity
        quantityInput.val(currentQuantity + 1); // Increase quantity by 1
        updateTotal(); // Recalculate the total
    } else {
            if (productId) {
                // Make an AJAX call to fetch product details
                $.ajax({
                    url: `/deal/product/${productId}`,
                    method: 'GET',
                    success: function (data) {
                        // Populate product details table
                        $('#product-details').prepend(data.html);
                        updateTotal();
                    }
                });
            } 


        }
        });
        $(document).on("change",'#is_product',function(){

if($(this).is(':checked')){
    $(".deal_section").css({
        "display":"none"
    });
    $("#is_product_value").val(1);
    $(".product_section").css({
        "display":"block"
    });
}else{
    $(".deal_section").css({
        "display":"block"
    });
    $(".product_section").css({
        "display":"none"
    })
    $("#is_product_value").val(0);
}

})
    
</script>
@endsection