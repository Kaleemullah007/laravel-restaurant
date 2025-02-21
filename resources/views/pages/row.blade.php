<div class="setting-row row d-flex " id="setting-row{{$new_row}}">
    <span class='totalrecord-settings'></span>
                                    <div class="col-lg-4 col-md-6 col-12 pt-1">
                                        <label for="product_id" class="form-label fs-6">{{ __('sales.Product') }}</label>
                                        <select
                                            class="form-select border-dark @error('product_id') is-invalid @enderror"
                                            name="products[{{$new_row}}][product_id]" id="{{$new_row}}-product_id" autocomplete="product_id"
                                             required  onchange="getPrice({{$new_row}})">
                                            <option>{{ __('sales.Choose') }}</option>
                                            @foreach ($products as $product)


                                                <option value="{{ $product->id }}" @if (in_array($product->id,$add_products))
                                                    style="{{'color:red'}}"
                                                    @endif>{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12 pt-1">
                                        <label for="qty" class="form-label fs-6">{{ __('sales.Quantity') }} <span id="{{ $new_row }}-available-stock" style="color:red" ></span></label>
                                        <input type="number" min="1"
                                            class="form-control calculation mb-2 border-dark @error('qty') is-invalid @enderror"
                                            id="{{$new_row}}-qty" name="products[{{$new_row}}][qty]" value="{{ old('qty',1) }}"
                                            autocomplete="qty" required autofocus  onkeyup="calcualtePrice()" min="1">
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
                                                id="{{$new_row}}-sale_price" name="products[{{$new_row}}][sale_price]" value="{{ old('sale_price') }}"
                                                autocomplete="sale_price"  autofocus  onkeyup="calcualtePrice()" min="0">
                                            @error('sale_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-12 d-flex align-items-end mb-2" id="setting-row{{$new_row}}-btn">
                                        <a href="javascript:void(0)" class="btn btn-primary " id="setting-row{{$new_row}}-href" onclick="addSetting({{$new_row}})"><i class="bi bi-plus-lg"></i></a>
                                    </div>
