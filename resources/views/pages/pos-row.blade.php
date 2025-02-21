   <tr class="" id="setting-row{{ $product->id }}">
       <th scope="row" class="text-wrap" style="width: 30%;">
           <span id="cart_product_code_{{ $product->id }}">{{ $product->product_code }}</span>
           <span class="d-flex fs-6 text-break">
               <span class="">{{ $product->name }} {{$product->variation}}
                {{-- <span class="badge bg-info text-dark">{{$product->variation}}</span> --}}
            </span>
               <input type="hidden" name="products[{{ $product->id }}][product_id]" value="{{ $product->id }}"
                   id="{{ $product->id }}_cart_product_code">
           </span>
       </th>

       <td style="width: 15%;" class="pt-2">{{ auth()->user()->currency }} 
        <span id="cart_product_price_{{ $product->id }}">{{ $product->sale_price }}</span>
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
            <input type="{{$hidden}}" class="form-control change_price" id="{{ $product->id }}_cart_product_price_change" name="products[{{$product->id}}][sale_price]" value="{{$product->sale_price}}">
            </td>
       <td style="width: 25%;" class="pt-2">
           <div class="input-group">
               <!-- Minus Button -->
               <button type="button" class="btn btn-danger" onclick="minusProductQty({{ $product->id }})">-</button>

               <!-- Quantity Input -->
               <input type="text" class="form-control text-center border-secondary" style="width: 50px !important;"
                   value="1" min="1" aria-label="Product quantity" aria-describedby="button-addon1"
                   name="products[{{ $product->id }}][qty]" id="cart_product_qty_{{ $product->id }}">

                   <span class="input-group-text px-1 border-secondary" id="basic-addon2">{{$product->unit}}</span>
               <!-- Plus Button -->
               <button type="button" class="btn btn-success text-white"
                   onclick="addProductQty({{ $product->id }})">+</button>
           </div>
       </td>

       {{-- <td style="width: 25%;" class="d-flex col-7 pt-2">
           <button type="button" class="btn btn-danger" onclick="minusProductQty({{ $product->id }})">-</i></button>
           <input type="text" class="form-control border-secondary" style="width: 50px;" value="1"
               min="1" aria-label="Example text with button addon" aria-describedby="button-addon1"
               min="1" id="cart_product_qty_{{ $product->id }}"> --}}
       {{-- onchange="ManualUpdate({{$product->id}})" --}}
       {{-- <button type="button" class="btn btn-success text-white"
               onclick="addProductQty({{ $product->id }})">+</button>
       </td> --}}
       <td style="width: 15%;" class="">
           {{ auth()->user()->currency }}<span class=" pe-3" id="sub_total_product_prices{{ $product->id }}">
               {{ $product->sale_price }}</span>

       </td>
       <td style="width: 15%;" class="">
           <button class="btn btn-info rounded-pill" onclick="removeCartRow({{ $product->id }})">
               <a href="#" id="setting-row{{ $product->id }}-href" class="text-white"><i
                       class="bi bi-trash"></i></a>
           </button>
       </td>
   </tr>

