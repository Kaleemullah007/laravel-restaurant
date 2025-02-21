<tr id="dp-{{$product->id}}" data-id={{$product->id}}>
    <td>{{$product->name}}     <input type="text" name="productss[{{$product->id}}][product_id]" value="{{$product->id}}" id=""></td>

    <td>{!! image('', $product->image, ['class=" border border-1"', 'style="height: 30px; width: 30px !important"']) !!}</td>
    <td class="productprice">{{$product->sale_price}}
        <input type="text" name="productss[{{$product->id}}][price]" value="{{$product->sale_price}}" id="">
    </td>
    <td > <input type="text" class="quantity" name="productss[{{$product->id}}][quantity]" value="1"></td>
    <td > <input type="checkbox" class="is_swappable" name="productss[{{$product->id}}][is_swappable]" ></td>
    <td onclick="removePRoduct({{$product->id}})">remove</td>
</tr>