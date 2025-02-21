@extends('layouts.master')

@section('title')
{{ __('sales.Create_Sale') }}
@endsection

@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('sales.Create_Sale') }}</h4>
                </div>
            </div>
            <hr>
            <div class="row p-3">
                <div class="shadow-css">
                    @include('message')
                    <form method="POST" action="{{ route('sale.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mt-3">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $key1 => $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @php

                                $counter = 0;

                            @endphp
                            <div class="setting">
                                @if (old('products'))
                                    @foreach (old('products') as $key => $product_old)
                                        <div class="setting-row row d-flex " id="setting-row{{ $key }}">
                                            <span class='totalrecord-settings'></span>
                                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                                <label for="product_id"
                                                    class="form-label fs-6">{{ __('sales.Product') }}</label>

                                                <select class="form-select  {!! $errors->has('products.' . $key . '.product_id') ? '  is-invalid' : 'border-dark' !!}"
                                                    name="products[{{ $key }}][product_id]"
                                                    id="{{ $key }}-product_id" autocomplete="product_id" required
                                                    onchange="getPrice({{$key}})"
                                                    >
                                                    <option>{{ __('sales.Choose') }}</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}" @selected($product_old['product_id'] == $product->id)>
                                                            {{ $product->name }} @if($product->variation)(<span class="badge bg-info text-dark">{{$product->variation}}</span>) @endif</option>
                                                    @endforeach
                                                </select>
                                                @error('products.' . $key . '.product_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->has("products.$key.product_id") }}
                                                        <strong>{{ $errors->first('products.' . $key . '.product_id') }} </strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                                <label for="qty"
                                                    class="form-label fs-6">{{ __('sales.Quantity') }}  <span id="{{ $key }}-available-stock" style="color:red" ></span> </label>
                                                <input name="products[{{ $key }}][qty]" type="text" min="0" 
                                                    class="form-control  mb-2 border-dark @error('qty') is-invalid @enderror"
                                                    id="{{ $key }}-qty"
                                                     value="{{ old('qty', $product_old['qty']) }}"
                                                    autocomplete="qty" required onkeyup="calcualtePrice()"
                                                    >
                                                @error('products.' . $key . '.qty')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('products.' . $key . '.qty') }} </strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-12 pt-1">
                                                <label for="sale_price"
                                                    class="form-label fs-6">{{ __('sales.Price') }}</label>
                                                <input type="text" min="1"
                                                    class="form-control calculation mb-2 border-dark @error('sale_price') is-invalid @enderror"
                                                    id="{{ $key }}-sale_price"
                                                    name="products[{{ $key }}][sale_price]"
                                                    value="{{ old('sale_price', $product_old['sale_price']) }}"
                                                    autocomplete="sale_price" required onkeyup="calcualtePrice()"
                                                    min="0">
                                                @error('products.' . $key . '.sale_price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('products.' . $key . '.sale_price') }} </strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            @if ($loop->last)
                                                <div class="col-lg-2 col-md-6 col-12 d-flex align-items-end mb-2"
                                                    id="setting-row{{ $key }}-btn">
                                                    <a href="#" class="btn btn-primary"
                                                        id="setting-row{{ $key }}-href"
                                                        onclick="addSetting({{ $key }})"><i
                                                            class="bi bi-plus-lg"></i></a>
                                                </div>
                                            @else
                                                <div class="col-lg-2 col-md-6 col-12 d-flex align-items-end mb-2"
                                                    id="setting-row{{ $key }}-btn">
                                                    <a href="#" class="btn btn-danger"
                                                        id="setting-row{{ $key }}-href"
                                                        onclick="removeSetting({{ $key }})"><i
                                                            class="bi bi-trash"></i></a>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="setting-row row d-flex " id="setting-row{{ $counter }}">
                                        <span class='totalrecord-settings'></span>
                                        <div class="col-lg-4 col-md-6 col-12 pt-1">
                                            <label for="product_id" class="form-label fs-6">{{ __('sales.Product') }}</label>
                                            <select
                                                class="form-select border-dark @error('product_id') is-invalid @enderror"
                                                name="products[{{ $counter }}][product_id]"
                                                id="{{ $counter }}-product_id"  autocomplete="product_id" required
                                                onchange="getPrice({{$counter}})"
                                                >
                                                <option>{{ __('sales.Choose') }}</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} @if($product->variation)(<span class="badge bg-info text-dark">{{$product->variation}}</span>) @endif</option>
                                                @endforeach
                                            </select>
                                            @error('product_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12 pt-1">
                                            <label for="qty" class="form-label fs-6">{{ __('sales.Quantity') }}<span id="{{ $counter }}-available-stock" style="color:red" ></span></label>
                                            <input type="text"  min="0" 
                                                class="form-control calculation mb-2 border-dark @error('qty') is-invalid @enderror"
                                                id="{{ $counter }}-qty" name="products[{{ $counter }}][qty]"
                                                @if(placeholderVisible()) placeholder={{ __('10')}}@endif value="{{ old('qty', 1) }}" autocomplete="qty" required
                                             onkeyup="calcualtePrice()">
                                            @error('qty')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-12 pt-1">
                                            <label for="sale_price" class="form-label fs-6">{{ __('sales.Price') }}</label>
                                            <input type="text" min="1"
                                                class="form-control calculation mb-2 border-dark @error('sale_price') is-invalid @enderror"
                                                id="{{ $counter }}-sale_price"
                                                name="products[{{ $counter }}][sale_price]" @if(placeholderVisible()) placeholder={{ __('999')}}@endif
                                                value="{{ old('sale_price') }}" autocomplete="sale_price"
                                             onkeyup="calcualtePrice()" min="0">
                                            @error('sale_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-12 d-flex align-items-end mb-2"
                                            id="setting-row{{ $counter }}-btn">
                                            <a href="#" class="btn btn-primary"
                                                id="setting-row{{ $counter }}-href"
                                                onclick="addSetting({{ $counter }})"><i
                                                    class="bi bi-plus-lg"></i></a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="user_id" class="form-label  fs-6">{{ __('sales.Customer') }} <span id="customer_amount"></span></label>
                                <div class="input-group input-group-md">
                                    <select
                                        class="form-select mb-2 border-dark select2 @error('user_id') is-invalid @enderror"
                                        name="user_id" id="user_id" autocomplete="user_id" onchange="getAmount('customer')" required>
                                        <option>{{ __('sales.Choose') }}</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"  @selected($customer->id == old('user_id')) >{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <!-- Button trigger for add customer -->
                                    <span class=" mb-2 ps-2" data-bs-toggle="modal" data-bs-target="#add_customer"><i
                                            class="bi fs-4 bi-person-plus-fill"></i></span>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="payment_status"
                                    class="form-label  fs-6">{{ __('sales.Payment_Status') }}</label>
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
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="payment_method"
                                    class="form-label  fs-6">{{ __('sales.Payment_Method') }}</label>
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
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="discount" class="form-label fs-6">{{ __('sales.Discount') }}</label>
                                <input type="text"  min="0" 
                                    class="form-control mb-2 calculation border-dark @error('discount') is-invalid @enderror"
                                    id="discount" name="discount" @if(placeholderVisible()) placeholder={{ __('100')}}@endif value="{{ old('discount', 0) }}"
                                    onkeyup="calcualtePrice()" autocomplete="discount" required>
                                @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="tax" class="form-label fs-6">{{ __('messages.Tax') }}</label>
                                <input type="text" min="0"
                                    class="form-control mb-2 calculation border-dark @error('tax') is-invalid @enderror"
                                    id="tax" name="tax" @if(placeholderVisible()) placeholder={{ __('100')}}@endif value="{{ old('tax', 0) }}"
                                    min="0" onkeyup="calcualtePrice()" autocomplete="tax" required>
                                @error('tax')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="shipping" class="form-label fs-6">{{ __('messages.Shipping') }}</label>
                                <input type="text" min="0"
                                    class="form-control mb-2 calculation border-dark @error('shipping') is-invalid @enderror"
                                    id="shipping" name="shipping" @if(placeholderVisible()) placeholder={{ __('100')}}@endif value="{{ old('shipping', 0) }}"
                                    min="0" onkeyup="calcualtePrice()" autocomplete="shipping" required>
                                @error('shipping')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            
                            {{-- <input type="number" min="1" name="sub_total" > --}}
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="remaining_amount" id="remaining_amount">

                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="paid_amount" class="form-label fs-6">{{ __('sales.Paid') }}</label>
                                <input type="text" min="0"
                                    class="form-control calculation mb-2 border-dark @error('paid_amount') is-invalid @enderror"
                                    id="paid_amount" name="paid_amount" @if(placeholderVisible()) placeholder={{ __('1000')}}@endif min="0"
                                    value="{{ old('paid_amount', 0) }}" autocomplete="paid_amount" required
                                    onkeyup="calcualtePrice()">
                                @error('paid_amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="due_date" class="form-label fs-6">{{ __('sales.Due_Date') }}</label>
                                <input type="date" min="0"
                                    class="form-control calculation mb-2 border-dark @error('due_date') is-invalid @enderror"
                                    id="due_date" name="due_date" min="0"
                                    value="{{ old('due_date', 0) }}"
                                    onkeyup="calcualtePrice()">
                                @error('due_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            

                        </div>
                        <div class="row justify-content-end mt-4">
                            <div class="col-lg-4 col-md-6 col-12">
                                <table class="table table-striped border table-sm border-secondary">
                                    <tbody>
                                        <tr>
                                            <th class="col-4">{{ __('sales.Sub_Total') }}</th>
                                            <td class="col-4 text-end" id="sub_total">0</td>
                                        </tr>
                                        <tr>
                                            <th class="col-4">{{ __('sales.Discount') }}</th>
                                            <td class="col-4 text-end" id="show_discount"> 0</td>
                                        </tr>
                                        <tr>
                                            <th class="col-4">{{ __('messages.Tax') }}</th>
                                            <td class="col-4 text-end" id="show_Tax">{{auth()->user()->currency}} 0</td>
                                        </tr>
                                        <tr>
                                            <th class="col-4">{{ __('messages.Shipping') }}</th>
                                            <td class="col-4 text-end" id="show_Shipping">{{auth()->user()->currency}} 0</td>
                                        </tr>
                                        <tr>
                                            <th class="col-4">{{ __('sales.Total') }}</th>
                                            <td class="col-4 text-end" id="show_total">{{auth()->user()->currency}} 0</td>
                                        </tr>
                                        <tr>
                                            <th class="col-4">{{ __('sales.Paid') }}</th>
                                            <td class="col-4 text-end" id="paid">{{auth()->user()->currency}} 0</td>
                                        </tr>
                                        <tr>
                                            <th class="col-4">{{ __('sales.Remaining') }}</th>
                                            <td class="col-4 text-end" id="remaining">{{auth()->user()->currency}} 0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- save button row included below -->
                        @include('pages.table-footer', ['link' => 'sale.index'])
                    </form>


                    <!-- Modal itself for add customer -->
                    <div class="modal fade" id="add_customer" tabindex="-1" aria-labelledby="add_customerLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form method="POST" action="" enctype="" id="FormDataCustomer">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="add_customerLabel">{{ __('sales.Add_Customer') }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="first_name" class="form-label fs-6">{{ __('sales.First_Name') }}</label>
                                        <input type="text"
                                            class="form-control mb-2 border-dark @error('first_name') is-invalid @enderror"
                                            id="first_name" name="first_name" @if(placeholderVisible()) placeholder={{ __('sales.First_Name')}}@endif
                                            value="{{ old('first_name') }}" autocomplete="first_name" required>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="last_name" class="form-label fs-6">{{ __('sales.Last_Name') }}</label>
                                        <input type="text"
                                            class="form-control mb-2 border-dark @error('last_name') is-invalid @enderror"
                                            id="last_name" name="last_name" @if(placeholderVisible()) placeholder={{ __('sales.Last_Name')}}@endif
                                            value="{{ old('last_name') }}" autocomplete="last_name" required>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="phone" class="form-label fs-6">{{ __('sales.Phone') }}</label>
                                        <input type="phone"
                                            class="form-control mb-2 border-dark @error('phone') is-invalid @enderror"
                                            id="phone" name="phone"  @if(placeholderVisible()) placeholder={{ __('+923001234567')}}@endif
                                            value="{{ old('phone') }}" autocomplete="phone" required>
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="email" class="form-label fs-6">{{ __('sales.Email') }}</label>
                                        <input type="email"
                                            class="form-control mb-2 border-dark @error('email') is-invalid @enderror"
                                            id="email" name="email"  @if(placeholderVisible()) placeholder={{ __('ABC123@example.com')}}@endif 
                                            value="{{ old('email') }}" autocomplete="email" >
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
  $(document).ready(function() {
    calcualtePrice();
  })
</script>
@endsection
