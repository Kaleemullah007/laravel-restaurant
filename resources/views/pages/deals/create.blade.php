@extends('layouts.master')

@section('title')
{{ __('deals.Create_Deal') }}
@endsection

@section('content')
<div class="container">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>{{ __('deals.Create_Deal') }}</h4>
            </div>
        </div>
        <hr>
        {{-- @dd($errors->all()) --}}
        <div class="row p-3">
            <div class="shadow-css">
                @include('message')
                <form method="POST" action="{{ route('deal.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Include an optional redirect link for deals --}}
                    @if (request('id'))
                    <input type="hidden" value="{{ request('id') }}" name="redirectid">
                    <a class="btn btn-secondary btn-md ms-2 mt-3" href="{{ route('deal.index') }}"><i
                            class="bi bi-arrow-left-circle me-1"></i>{{ __('deals.Back_to_Deals') }} </a>
                    @endif
                   

                       
                    <div class="row mt-3">
                        <!-- Name of Deal -->
                        <div class="col-lg-4 col-md-6 col-12 pt-1">
                            <label for="deal_name" class="form-label fs-6">{{ __('deals.Deal_Name') }}</label>
                            <input type="text"
                                class="form-control mb-2 border-dark @error('deal_name') is-invalid @enderror"
                                id="deal_name" name="deal_name" value="{{ old('deal_name') }}" autocomplete="deal_name"
                                required>
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
                                id="deal_code" name="deal_code" value="{{ old('deal_code') }}" autocomplete="deal_code"
                                required>
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
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}" @selected(old('product_id')==$product->id)>
                                    {{ $product->name }}
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
                                id="start_time" name="start_time" value="{{ old('start_time') }}" required>
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
                                id="end_time" name="end_time" value="{{ old('end_time') }}" required>
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
                                id="deal_price" name="deal_price" value="{{ old('deal_price') }}" required>
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
                                <option value="active" @selected(old('status')=='active' )>{{ __('deals.Active') }}
                                </option>
                                <option value="inactive" @selected(old('status')=='inactive' )>{{ __('deals.Inactive')
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
                            <img id="imageInputDeals"
                                 src="{{ asset('/assets/images/no-image.png') }}" 
                                 class="rounded-pill mt-1 ms-3 border border-3"
                                 style="height: 60px; width: 60px !important"
                                 alt="Selected Image">
                        </div>
                    </div>

                    <!-- Selected Product Details -->
                    <div class="row mt-3" id="selected-product">
                        <div class="col-12">
                            <h5>{{ __('deals.Selected_Product_Details') }} {{ auth()->user()->currency}}<span class="text-danger" id="total-price"></span> </h5>
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
                                    {{-- <tr>
                                        <td colspan="5" class="text-center">{{ __('deals.No_Product_Selected') }}</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Save Button -->
                    @include('pages.table-footer', ['link' => 'deal.index'])

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
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
       
</script>
@endsection