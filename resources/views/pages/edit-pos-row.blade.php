@foreach ($products as $product )
    

<tr class="" id="setting-row{{ $product->product_id }}">
       <th scope="row" class="text-wrap" style="width: 30%;">
           <span id="cart_product_code_{{ $product->product_id }}">{{ $product->product->product_code }}</span>
           <span class="d-flex fs-6 text-break">
               <span class="">{{ $product->product->name }} {{$product->product->variation}}
                <div class="flex-col"><input type="radio" value="D" onchange="posCalcualtePrice()" name="products[{{ $product->product_id }}][product_status]" onchange="posCalcualtePrice()">D <input type="radio" value="E" name="products[{{ $product->product_id }}][product_status]" onchange="posCalcualtePrice()">E <input type="radio" value="N" name="products[{{ $product->product_id }}][product_status]" checked   onchange="posCalcualtePrice()">N</div>
            </span>
               <input type="hidden" name="products[{{ $product->product_id }}][product_id]" value="{{ $product->product_id }}"
                   id="{{ $product->product_id }}_cart_product_code">
           </span>
       </th>

       <td style="width: 15%;" class="pt-2">{{ auth()->user()->currency }} <span
               id="cart_product_price_{{ $product->product_id }}">{{ $product->sale_price }}</span>
               @php
               $hidden = 'hidden'; 
               if(auth()->user()->user_type == 'superadmin'){
                   $hidden = 'number'; 
               }
               elseif(auth()->user()->user_type == 'admin'  && auth()->user()->change_price){
                   $hidden = 'number'; 
               }
               elseif(auth()->user()->user_type == 'employee' && auth()->user()->change_price){
                   
                   $hidden = 'number'; 
       
               }
               @endphp
            <input type="{{$hidden}}" class="form-control change_price" id="{{ $product->id }}_cart_product_price_change" name="products[{{$product->product_id}}][sale_price]" value="{{$product->sale_price}}">
            </td>
       <td style="width: 25%;" class="pt-2">
           <div class="input-group">
               <!-- Minus Button -->
               <button type="button" class="btn btn-danger" onclick="minusProductQty({{ $product->product_id }})">-</button>

               <!-- Quantity Input -->
               <input type="text" class="form-control text-center border-secondary" style="width: 50px !important;"
                   value="{{ $product->qty }}" min="1" aria-label="Product quantity" aria-describedby="button-addon1"
                   name="products[{{ $product->product_id }}][qty]" id="cart_product_qty_{{ $product->product_id }}">

               <!-- Plus Button -->
               <button type="button" class="btn btn-success text-white"
                   onclick="addProductQty({{ $product->product_id }})">+</button>
           </div>
       </td>

       {{-- <td style="width: 25%;" class="d-flex col-7 pt-2">
           <button type="button" class="btn btn-danger" onclick="minusProductQty({{ $product->product_id }})">-</i></button>
           <input type="text" class="form-control border-secondary" style="width: 50px;" value="1"
               min="1" aria-label="Example text with button addon" aria-describedby="button-addon1"
               min="1" id="cart_product_qty_{{ $product->product_id }}"> --}}
       {{-- onchange="ManualUpdate({{$product->product_id}})" --}}
       {{-- <button type="button" class="btn btn-success text-white"
               onclick="addProductQty({{ $product->product_id }})">+</button>
       </td> --}}
       <td style="width: 15%;" class="">
           {{ auth()->user()->currency }}<span class=" pe-3" id="sub_total_product_prices{{ $product->product_id }}">
               {{ $product->sale_price }}</span>

       </td>
       <td style="width: 15%;" class="">
           <button class="btn btn-info rounded-pill" onclick="removeCartRow({{ $product->product_id }})">
               <a href="#" id="setting-row{{ $product->product_id }}-href" class="text-white"><i
                       class="bi bi-trash"></i></a>
           </button>
       </td>
   </tr>

   @endforeach