@extends('layouts.pos_layout')


@section('content')
    <!-- pos -->
    {{-- <div class="container-fluid body bg-css-2"> --}}

    {{-- @dd($errors->all()) --}}

    <div class="container-fluid row d-flex body h-100 me-0 pe-0">



        <div class="col-lg-5 col-md-7 col-12 bg-white">
            <div class="row  py-2 align-items-center">
                <div class="col-2">
                    <a href="{{ route('dashboard') }}">
                        <img src="/assets/images/logo-no-background.png" class="logo-image" alt="logo">
                    </a>
                </div>
              
                <div class="col-8 d-flex justify-content-end align-items-center">
                    <a href="{{ route('dashboard') }}" class="btn btn-sm p-0 px-2" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"aria-expanded="false">
                        <i class="bi bi-house-fill fs-4"></i>
                    </a>
                    <button id="fullscreen-btn" class="btn btn-lg py-1 px-2 mx-2"><i class="bi bi-arrows-fullscreen fs-5"></i> </button>
                    {{-- <a href="" class="btn btn-lg"><i class="bi bi-globe2"></i> </a> --}}
                    
                    <a href="{{is_null($sale)?'#':route('sale.slip',$sale->id??'')}}" data-id="{{$sale->id??''}}" class="btn btn-info text-dark me-3" id="print_id" target="_blank"
                        rel="noopener noreferrer"><i class="bi bi-printer"></i> {{ __('datatables.print') }}</a>

                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                        class="btn btn-danger text-white">
                        <span><i class="bi bi-box-arrow-left"></i></span> {{ __('messages.Logout') }}
                    </a>


                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
                <div class="col-2">
                    <ul class="navbar-item flex-row ms-auto">
                        <li class="nav-item dropdown has-arrow flag-nav">
                            @include('layouts.localization')

                        </li>
                        </ul>
                </div>
            </div>

            {{-- <hr class="text-dark border-4 shadow-lg mt-0"> --}}
            
            <form method="POST" action="{{ route('employeepos') }}" id="myForm">
                @csrf
                <hr class="text-dark border-4 shadow-lg mt-0">
                <div class="row my-2">
                    <div class="col-sm-7">
                        <div class="row ">
                            <div class="col-1 d-flex vh-10 align-items-center">
                                <div id="customer_amount" class=""></div>
                            </div>
                            <div class="col-7 pe-0 m-0">
                                {{-- <div class=" "> --}}
                                    <select aria-label="Default select example"
                                        class="form-select border-secondary select2 @error('user_id') is-invalid @enderror"
                                        name="user_id" id="user_id" autocomplete="user_id"  onchange="getAmount('customer')" required>
                                        <option value="">{{ __('messages.choose') }}</option>
                                        @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" @selected($customer->id == old('user_id'))>{{
                                            $customer->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                {{-- </div> --}}

                            </div>
                            <!-- model trigger for create customer -->
                            <div class="col-4 p-0 m-0">
                                <button class="btn btn-success text-white px-1" type="button" id="button-addon2" data-bs-toggle="modal"
                                    data-bs-target="#add_customer">
                                    <i class="bi bi-person-plus"></i> {{ __('messages.Create') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="row">
                            <div class="col-sm-4 ps-0">
                                <input type="checkbox" class="py-0" name="is_edit" id="is_edit" data-toggle="toggle" data-on="ON"
                                    data-off="OFF" data-onstyle="info" data-offstyle="danger">
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="m_sale_id" id="m_sale_id" class="form-control" style="display: none;">
                            </div>
                        </div>
                    </div>




                </div>
                <div class="container-flid bg-light">
                    <div class="custom-table-responsive table-responsive">
                        <table class="table align-middle table-sm">
                            <thead class="fw-bold">
                                <tr>
                                    <th style="width: 25%;">{{ __('messages.product') }}</th>
                                    <th style="width: 15%;">{{ __('messages.price') }}</th>
                                    <th style="width: 35%;">{{ __('messages.quantity') }}</th>
                                    <th style="width: 15%;">{{ __('messages.Sub-Total') }}</th>
                                    <th style="width: 10%;">{{ __('messages.action') }}</th>
                                    {{-- <th colspan="3">
                                        {{ __('messages.Product') }}
                                    </th>
                                    <th colspan="2">
                                        {{ __('messages.Price') }}
                                    </th>
                                    <th colspan="3">
                                        {{ __('messages.Quantity') }}
                                    </th>
                                    <th colspan="2">
                                        {{ __('messages.Sub-Total') }}
                                    </th>
                                    <th colspan="2">
                                        {{ __('messages.Action') }}
                                    </th> --}}
                                </tr>
                            </thead>
                            <div class="over-1d">
                                <input type="hidden" id="sale_id" name="sale_id" >
                                <tbody class="setting" style="">

                                </tbody>
                            </div>
                        </table>
                    </div>
                    <hr class="text-dark border-4 shadow-lg my-0 py-0">

                    <div class="row mt-df3 px-3">
                        <div class="col-lg-4 col-md-6 col-12 mt-2">
                            <span>{{ __('messages.Tax') }}</span>
                            <div class="input-group">
                                <input type="number" class="form-control border-dark" id="tax"
                                    aria-label="Amount (to the nearest dollar)" name="tax" value="0">
                                <span class="input-group-text border-dark">%</span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 mt-2">
                            <span>{{ __('messages.Discount') }}</span>
                            <div class="input-group">
                                <input type="number" class="form-control border-dark"
                                    aria-label="Amount (to the nearest dollar)" value="0" name="discount"
                                    id="discount">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 mt-2">
                            <span>{{ __('messages.Shipping') }}</span>
                            <div class="input-group">
                                <input type="number" class="form-control border-dark"
                                    aria-label="Amount (to the nearest dollar)" value="0" name="shipping"
                                    id="shipping">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mt-2">
                            {{-- <label for="payment_status" class="form-label  fs-6">{{ __('messages.Payment Status') }}</label>
                            --}}
                            <span>{{ __('messages.Payment Status') }}</span>

                            <select class="form-select mb-2 border-dark @error('payment_status') is-invalid @enderror"
                                name="payment_status" id="payment_status" autocomplete="payment_status" required>
                                {!! paymentStatus(old('payment_status')) !!}
                            </select>
                            @error('payment_status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 mt-2">
                            {{-- <label for="payment_method" class="form-label  fs-6">{{ __('messages.Payment Method') }}</label>
                            --}}
                            <span>{{ __('messages.Payment Method') }}</span>
                            <select class="form-select mb-2 border-dark @error('payment_method') is-invalid @enderror"
                                name="payment_method" id="payment_method" autocomplete="payment_method" required>
                                {!! paymentMethods(old('payment_method')) !!}

                            </select>
                            @error('payment_method')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 mt-2">
                            <span>{{ __('messages.Paid') }}</span>
                            <input type="number" min="0"
                                class="form-control calculation mb-2 border-dark @error('paid') is-invalid @enderror"
                                id="paidsss" name="paid_amount" min="0" {{-- value="{{ old('paid', 0) }}" --}} required
                                onchange="paidamountCal()" />
                            @error('paid')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <input type="hidden" name="total" id="total_">
                        <input type="hidden" name="remaining_amount" id="remaining_amount">
                        <div class="row justify-content-end mt-4">
                            <div class="col-lg-6 col-md-6 col-12">
                                <table class="table rounded border table-sm border-secondary">
                                    <tbody>
                                        <tr>
                                            <td class="col-4"><span class="fs-6">{{ __('messages.Total Products') }}</span>
                                            </td>
                                            <td class="col-4 text-end" id="1sss">
                                                <span class="btn badge btn-primary rounded-pill fw-bold"
                                                    id="total_product_view">00</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-4"><span class="fs-6">{{ __('messages.Sub-Total') }}</span></td>
                                            <td class="col-4 text-end">{{ auth()->user()->currency }}<span
                                                    id="sub_total">0</span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-4"><span class="fs-6">{{ __('messages.Discount') }}</span></td>
                                            <td class="col-4 text-end">{{ auth()->user()->currency }}<span
                                                    id="show_discount">0</span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-4"><span class="fs-6">{{ __('messages.Tax') }}</span></td>
                                            <td class="col-4 text-end" id="">{{auth()->user()->currency}}<span id="tax_view"> 0 </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-4"><span class="fs-6">{{ __('messages.Shipping') }}</span></td>
                                            <td class="col-4 text-end">{{ auth()->user()->currency }}<span
                                                    id="show_shipping">0</span></td>
                                        </tr>
                                        <tr>
                                            <th class="col-4"><span class="fs-6">{{ __('messages.Grand Total') }}</span>
                                            </th>
                                            <th class="col-4 text-end">{{ auth()->user()->currency }}<span
                                                    id="total">0</span> </th>
                                        </tr>
                                        <tr>
                                            <td class="col-4"><span class="fs-6">{{ __('messages.Paid') }}</span></td>
                                            <td class="col-4 text-end">{{ auth()->user()->currency }}<span
                                                    id="paid_view">0</span></td>
                                        </tr>
                                        <tr>
                                            <td class="col-4"><span class="fs-6">{{ __('messages.Remaining') }}</span></td>
                                            <td class="col-4 text-end">{{ auth()->user()->currency }}<span
                                                    id="remaining">0</span></td>
                                        </tr>
                                    </tbody>
                                    {{-- <div class="list-group">
                                        <div class="list-group-item d-flex justify-content-between border-secondary">
                                            {{ __('messages.Total Products') }}
                                            <span class="btn badge btn-primary rounded-pill fw-bold">1</span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between border-secondary">
                                            {{ __('messages.Order Tax') }}
                                            <span class="fw-bold"> 0.00 (0 %)</span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between border-secondary">
                                            {{ __('messages.Discount') }}
                                            <span class="fw-bold"> 0.00</span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between border-secondary">
                                            {{ __('messages.Shipping') }}
                                            <span class="fw-bold"> 0.00</span>
                                        </div>
                                        <div
                                            class="list-group-item d-flex justify-content-between border-secondary fw-bold">
                                            {{ __('messages.Grand Total') }}
                                            {{ auth()->user()->currency }} <span class="fw-bold"> 0.0</span>
                                        </div>
                                    </div> --}}
                                </table>
                            </div>
                        </div>
                        <div class="bg-css-1 p-1  text-center rounded">
                            <h4 class="text-dark fs-4 fw-bold">{{ __('messages.Grand Total') }} :
                                {{ auth()->user()->currency }}
                                <span id="grand_view">0.00</span>
                            </h4>
                        </div>
                    </div>

                    <div class="row py-3 pb-4 justify-content-center">
                        <div class="col-lg-6 col-md-6 col-12 mt-2">
                            <button type="button" onclick="resetForm()" class="btn btn-danger btn-md text-white rounded-pill w-100">
                                <i class="bi bi-x-circle"></i> {{ __('messages.Reset') }}
                            </button>
                            {{-- <a href="/" class="btn btn-danger btn-md text-white rounded-pill w-100 "><i
                                    class="bi bi-x-circle"></i> {{ __('messages.Reset') }}</a> --}}
                        </div>

                        
                        <div class="col-lg-6 col-md-6 col-12 mt-2">
                            <button type="button" onclick="submitForm(event)" id="actionOne"
                                class="btn btn-success btn-md text-white rounded-pill w-100">
                                <i class="bi bi-cart4"></i> {{ __('messages.Proceed to Pay') }}
                            </button>


                        </div>

                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-7 col-md-5 col-12 bg-white border-start border-5">
            <div class="row">
                <div class="d-flex align-items-center justify-content-center mt-2">
                <span class="fs-4 text-center fw-bold pt-1 me-3">{{ __('messages.Products') }} </span>
                <input type="checkbox" class="py-0" name="barcodeActive" id="barcodeActive" data-toggle="toggle"
                data-on="Auto" data-off="Manual" data-onstyle="danger" data-offstyle="info">

                </div>
                {{-- <input type="checkbox"> --}}
                <div class="input-group input-group-lg mt-2">
                    <input type="text" class="form-control border-dark" aria-label="sarch product"
                        placeholder="{{ __('messages.search_notice') }}" id="search"
                        onkeyup="getProductsForPos()" aria-describedby="sarch product">
                </div>
            </div>
            <div class="row mt-3 overflow-css-2" id="searchable">
                @php
                    $counter = 0;
                @endphp
                @foreach ($products as $product)
                    <div class="col-lg-2 col-md-4 col-6 mt-2">
                        <div class="card rounded border-1 border-dark pb-3" id="original_product{{ $product->id }}"
                            onclick="addProductToCart({{ $product->id }})" style="height: 100% !important;">
                            {{-- <img src="/assets/images/img7.png" class="card-img-top position-relative" alt="..."> --}}
                            {!! image('', $product->image, [
                                'class="card-img-top position-relative"',
                                'style="height: 80px !important"',
                            ]) !!}



                            <span class="position-css-1 badge fw-light rounded-pill bg-dark ">
                            <span id="stock_product{{ $product->id }}">{{ $product->stock }}</span>
                            {{ $product->unit }}
                                </span>
                                
                            <input type="hidden" id="original_stock_product{{ $product->id }}"
                                value="{{ $product->stock }}" />
                                        {{-- <div class="card-body-- px-1 pb-1">
                                    <span>{{ $product->name }}</span><br>
                                    <span>{{ $product->product_code }}</span><br>

                                    <h5 class="badge fs-6 mb-0 fw-light bg-success text-white "
                                        style="margin-bottom: 10px !important">{{ auth()->user()->currency }}
                                        {{ $product->price }}</h5>
                                </div> --}}

                            <div class="card-body position-relative px-1 pt-0 mt-0" style="width: 100% !important;">
                                <span class="fw-bold">{{ $product->product_code }}</span><br>
                                <span class="">{{ $product->name }} {{ $product->variation }}
                                    {{-- <span class="badge bg-info text-dark">{{ $product->variation }}</span> --}}
                                </span>
                                <h5 class="badge fs-6 fw-light bg-success text-white position-absolute text-wrap"
                                    style="top: 80%;left: 3%;">
                                    {{ auth()->user()->currency }} {{ $product->sale_price }}
                                </h5>
                            </div>


                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    </div>
    {{-- </div> --}}
@endsection


@section('script')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function submitForm(event) {
            event.preventDefault(); // Prevent default form submission
            event.preventDefault(); // Prevent default form submission
            let action = $('#myForm').attr('action');
            var formData = $('#myForm').serialize();

            posCalcualtePrice();
            console.log(formData);


            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content"),
                },
            });

            $.ajax({
                type: "POST",
                url: action,
                data: formData,
                success: function(data) {
                    if(data.error){
                        toastr.error(data.message);
                    

                    }else{

                    $("#total").text(0);
                    $("#paid_view").text(0);
                    $("#remaining").text(0);
                    $("#grand_view").text(0);
                    $("#sub_total").text(0);
                    $("#total_product_view").text(0);
                    $("#show_discount").text(0);
                    $("#tax_view").text(0);
                    $("#show_shipping").text(0);
                    
                        toastr.success('Your order has been placed successfully!', 'Success');
                        $('.setting > tr').remove();

                        $("#myForm")[0].reset();
                        $('#user_id').val(null).trigger('change');
                        $("#print_id").attr('href', `{{ route('sale.slip', '') }}/${data.id}`);
                        $("#print_id").attr('data-id', `${data.id}`);

                }
                },
                error: function(jqXHR) {
                    // Handle error response
                    if (jqXHR.status === 422) { // 422 Unprocessable Entity
                        var errors = jqXHR.responseJSON.errors; // Get errors from the response
                        if (errors) {
                            // Get the first error message from the first field
                            var firstFieldName = Object.keys(errors)[0]; // Get the first field name
                            var firstErrorMessage = errors[firstFieldName][0]; // Get the first error message

                            toastr.error(firstErrorMessage, 'Error');
                        }
                    } else {

                        alert("An unexpected error occurred. Please try again.");
                    }
                }
            });

        }
        $(document).on("change",'#is_edit',function(){

            var id = $("#print_id").data('id');
            $("#sale_id").val(null)
            if ($("#is_edit").is(':checked')) {
                $("#m_sale_id").css({"display": "block"});
                toastr.error('Order edit Mode', 'success');
                $("#sale_id").val(id)
                getSaleProducts(id)

                    }
                    else{
                        $("#sale_id").val(null)
                        $("#m_sale_id").css({"display": "none"});
                        $(".setting").html('');
                        toastr.success('Order Creation Mode', 'success');
                        $("#shipping").val(0);
                        $("#total").text(0);
                    $("#paid_view").text(0);
                    $("#remaining").text(0);
                    $("#grand_view").text(0);
                    $("#sub_total").text(0);
                    $("#total_product_view").text(0);
                    $("#show_discount").text(0);
                    $("#tax_view").text(0);
                    $("#show_shipping").text(0);
                    $("#tax").val(0);
                    $("#discount").val(0);
                    $("#payment_status").val(0);
                    $("#payment_method").val(0);
                    $("#paidsss").val(0);   
                    $('#user_id').val(null).trigger('change'); 
                    posCalcualtePrice();    
                    }
        })

        $("#m_sale_id").keypress(function(event) {
        if (event.which === 13) { // 13 is the Enter key code
            event.preventDefault();
            getSaleProducts($(this).val())
            $("#sale_id").val($(this).val())

        }
    });

    function getSaleProducts(id){

        $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $(
                            'meta[name="csrf-token"]'
                        ).attr("content"),
                    },
                });

            $.ajax({
                type: "get",
                url: '{{ route("sale.viewsale",'') }}/' + id,
                // dataType: 'html',
                success: function(data) 
                {
                    if(data.error === true){
                        toastr.error('Time is over for Editing sale', 'Time Over');
                    }else{
                        $(".setting").html('');
                    $(".setting").append(data.html)
                    $('#user_id').val(data.sale.user_id).trigger('change');

                        $("#tax").val(data.sale.tax);
                        $("#shipping").val(data.sale.shipping);

                        $("#discount").val(data.sale.discount);
                        $("#payment_status").val(data.sale.payment_status);
                        $("#payment_method").val(data.sale.payment_method);
                        $("#paidsss").val(data.sale.paid_amount);            
                        posCalcualtePrice();
                
                    }
                    
                
                },
                error: function(jqXHR) {
                        // Handle error response
                        if (jqXHR.status === 422) { // 422 Unprocessable Entity
                            var errors = jqXHR.responseJSON.errors; // Get errors from the response
                            if (errors) {
                                // Get the first error message from the first field
                                var firstFieldName = Object.keys(errors)[0]; // Get the first field name
                                var firstErrorMessage = errors[firstFieldName][0]; // Get the first error message

                                toastr.error(firstErrorMessage, 'Error');
                            }
                        } else {
                            $(".setting").html('');
                            toastr.error('No Sale Found', 'Error');
                            $("#total").text(0);
                        $("#paid_view").text(0);
                        $("#remaining").text(0);
                        $("#grand_view").text(0);
                        $("#sub_total").text(0);
                        $("#total_product_view").text(0);
                        $("#show_discount").text(0);
                        $("#tax_view").text(0);
                        $("#show_shipping").text(0);
                        $("#tax").val(0);
                        $("#shipping").val(0);

                        $("#discount").val(0);
                        $("#payment_status").val(0);
                        $("#payment_method").val(0);
                        $("#paidsss").val(0);    
                        posCalcualtePrice();        
                        }
                    }

            });

    }

    </script>
@endsection
