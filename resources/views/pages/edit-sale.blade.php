@extends('layouts.master')

@section('title')
    {{ __('sales.Edit_Sale') }}
@endsection

@section('content')
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ __('sales.Edit_Sale') }}</h4>
                </div>
            </div>
            <hr>
            <div class="row p-3">
                <div class="shadow-css">
                    @include('message')
                    <form method="POST" action="{{route('sale.update',$sale->id)}}" enctype="">
                        @method('patch')
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
                                $counter = 1;
                            @endphp
                            <div class="setting">
                                @if (old('products'))
                                @foreach (old('products') as $key => $product_old)
                                    <div class="setting-row row d-flex " id="setting-row{{ $key }}">
                                        <span class='totalrecord-settings'></span>
                                        <div class="col-lg-4 col-md-6 col-12 pt-1">
                                            <label for="product_id"
                                                class="form-label fs-6">{{ __('sales.Product') }}</label>
                                            <?php $selected_qty =0; ?>
                                            <select class="form-select  {!! $errors->has('products.' . $key . '.product_id') ? '  is-invalid' : 'border-dark' !!}"
                                                name="products[{{ $key }}][product_id]"
                                                id="{{ $key }}-product_id" autocomplete="product_id" required
                                                onchange="getPrice({{$key}})"
                                                >
                                                <option>{{ __('sales.Choose') }}</option>
                                                @foreach ($products as $product)
                                                @if($product_old['product_id'] == $product->id)
                                                @php
                                                    $selected_qty =$product->stock
                                                @endphp
                                                @endif
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
                                                class="form-label fs-6">{{ __('sales.Quantity') }}<span id="{{ $key }}-available-stock" style="color: red; font-size: 12px; font-weight: bold;" > Available({{$selected_qty}})</span></label>
                                            <input name="products[{{ $key }}][qty]" type="text" min="0" 
                                                class="form-control  mb-2 border-dark @error('qty') is-invalid @enderror"
                                                id="{{ $key }}-qty"
                                                placeholder="20" value="{{ old('qty', $product_old['qty']) }}"
                                                autocomplete="qty" required autofocus onkeyup="calcualtePrice()"
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
                                                name="products[{{ $key }}][sale_price]" placeholder="10"
                                                value="{{ old('sale_price', $product_old['sale_price']) }}"
                                                autocomplete="sale_price"  autofocus onkeyup="calcualtePrice()"
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
                                                    rel="setting-row{{ $key }}"
                                                    onclick="removeSetting({{ $key }})"><i
                                                        class="bi bi-trash"></i></a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                @foreach ($sale->Products as $sale_product )
                                    <div class="setting-row row d-flex " id="setting-row{{ $counter }}">
                                        <span class='totalrecord-settings'></span>
                                        <div class="col-lg-4 col-md-6 col-12 pt-1">
                                            @php
                                                $selected_qty =0
                                            @endphp
                                            <label for="product_id" class="form-label fs-6">{{ __('sales.Product') }}</label>
                                            <select class="form-select border-dark @error('product_id') is-invalid @enderror"
                                                name="products[{{ $counter }}][product_id]"
                                                id="{{ $counter }}-product_id" autocomplete="product_id" required
                                                onchange="getPrice({{$counter}})">
                                                <option>{{ __('sales.Choose') }}</option>
                                                @foreach ($products as $product)

                                                @if($sale_product->product_id == $product->id)
                                                @php
                                                    $selected_qty =$product->stock
                                                @endphp
                                                @endif

                                                    <option value="{{ $product->id }}" @selected($sale_product->product_id==$product->id) >{{ $product->name }} @if($product->variation)(<span class="badge bg-info text-dark">{{$product->variation}}</span>) @endif</option>
                                                @endforeach
                                            </select>
                                            @error('product_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12 pt-1">
                                            <label for="qty" class="form-label fs-6">{{ __('sales.Quantity') }}<span id="{{ $counter }}-available-stock" style="@if($selected_qty > 0)color: green; @else  color: red; @endif font-size: 12px; font-weight: bold;" > Available({{$selected_qty}})</span></label>
                                            <input type="text"  min="0" 
                                                class="form-control calculation mb-2 border-dark @error('qty') is-invalid @enderror"
                                                id="{{ $counter }}-qty" name="products[{{ $counter }}][qty]"
                                                placeholder="20" value="{{ old('qty', $sale_product->qty) }}" autocomplete="qty" required
                                                autofocus onkeyup="calcualtePrice()">
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
                                                name="products[{{ $counter }}][sale_price]" placeholder="10"
                                                value="{{ old('sale_price',$sale_product->sale_price) }}" autocomplete="sale_price"  autofocus
                                                onkeyup="calcualtePrice()" min="0">
                                            @error('sale_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                                @if ($loop->last)
                                                <div class="col-lg-2 col-md-6 col-12 d-flex align-items-end mb-2"
                                                    id="setting-row{{ $counter }}-btn">
                                                    <a href="#" class="btn btn-primary"
                                                        id="setting-row{{ $counter }}-href"
                                                        onclick="addSetting({{ $counter }})"><i
                                                            class="bi bi-plus-lg"></i></a>
                                                </div>
                                            @else
                                                <div class="col-lg-2 col-md-6 col-12 d-flex align-items-end mb-2"
                                                    id="setting-row{{ $counter }}-btn">
                                                    <a href="#" class="btn btn-danger"
                                                        id="setting-row{{ $counter }}-href"
                                                        rel="setting-row{{ $counter }}"
                                                        onclick="removeSetting(this.rel)" ><i
                                                            class="bi bi-trash"></i></a>
                                                </div>
                                            @endif




                                    </div>
                                    @php
                                    $counter++
                                    @endphp
                                @endforeach
                                @endif
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="user_id" class="form-label fs-6">{{ __('sales.Customer') }} <span id="customer_amount"></span></label>
                                <select class="form-select mb-2 border-dark @error('user_id') is-invalid @enderror" name="user_id" id="user_id" autocomplete="user_id"  onchange="getAmount('customer')" required>
                                    <option>{{ __('sales.Choose')}}</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{$customer->id}}" @selected($customer->id == $sale->user_id) >{{$customer->name}}</option>
                                    @endforeach

                                </select>
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            

                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="payment_status" class="form-label  fs-6">{{ __('sales.Payment_Status') }}</label>
                                <select
                                    class="form-select mb-2 border-dark @error('payment_status') is-invalid @enderror"
                                    name="payment_status" id="payment_status" autocomplete="payment_status" required>
                                    {!! paymentStatus($sale->payment_status) !!}
                                </select>
                                @error('payment_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="payment_method" class="form-label  fs-6">{{ __('sales.Payment_Method') }}</label>
                                <select
                                    class="form-select mb-2 border-dark @error('payment_method') is-invalid @enderror"
                                    name="payment_method" id="payment_method" autocomplete="payment_method" required>
                                    {!! paymentMethods($sale->payment_method) !!}
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
                                    class="form-control calculation bg-grey mb-2 border-dark @error('discount') is-invalid @enderror"
                                    id="discount" name="discount" value="{{ old('discount',$sale->discount) }}"
                                    autocomplete="discount" required autofocus onchange="calcualtePrice()">
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
                                    id="tax" name="tax" @if(placeholderVisible()) placeholder={{ __('100')}}@endif value="{{ old('tax', $sale->tax) }}"
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
                                    id="shipping" name="shipping" @if(placeholderVisible()) placeholder={{ __('100')}}@endif value="{{ old('shipping', $sale->shipping) }}"
                                    min="0" onkeyup="calcualtePrice()" autocomplete="shipping" required>
                                @error('shipping')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <input type="number" min="1" name="sub_total" > --}}
                            <input type="hidden" name="total" >
                            <input type="hidden" name="remaining_amount" >

                            <div class="col-lg-4 col-md-6 col-12 pt-1">
                                <label for="paid_amount" class="form-label fs-6">{{ __('sales.Paid') }}</label>
                                <input type="text"  min="0" 
                                    class="form-control calculation bg-grey mb-2 border-dark @error('paid_amount') is-invalid @enderror"
                                    id="paid_amount" name="paid_amount" value="{{ old('paid_amount',$sale->paid_amount) }}"
                                    autocomplete="paid_amount" required autofocus onchange="calcualtePrice()">
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
                                    id="due_date" name="due_date" placeholder="70" min="0"
                                    value="{{ old('due_date', $sale->due_date) }}"
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
                                            <th class="col-4">{{ __('sales.Sub_Total')}}</th>
                                            <td class="col-4 text-end" id="sub_total">{{$sale->total-$sale->discount}}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-4">{{ __('sales.Discount')}}</th>
                                            <td class="col-4 text-end" id="show_discount">{{$sale->discount}}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-4">{{ __('messages.Tax') }}</th>
                                            <td class="col-4 text-end" id="show_Tax"> {{ $sale->tax }}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-4">{{ __('messages.Shipping') }}</th>
                                            <td class="col-4 text-end" id="show_Shipping"> {{ $sale->shipping }}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-4">{{ __('sales.Total')}}</th>
                                            <td class="col-4 text-end" id="show_total">{{$sale->total}}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-4">{{ __('sales.Paid')}}</th>
                                            <td class="col-4 text-end" id="paid">{{$sale->paid_amount}}</td>
                                        </tr>
                                        <tr>
                                            <th class="col-4">{{ __('sales.Remaining')}}</th>
                                            <td class="col-4 text-end" id="remaining">{{$sale->remaining_amount}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- save button row included below -->
                        @include('pages.table-footer',['link'=>'sale.index'])
                    </form>
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

