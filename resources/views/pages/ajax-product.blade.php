@include('message')
@if (request('id'))
<a  class="btn btn-secondary btn-md mb-2 ps-2 " href="{{route('purchase.create')}}"><span><i class="bi fs-6  bi-arrow-left-circle"> Create Purchase</i></span></a>
@endif

<table class="table border align-middle">

    
    <thead>
        <tr>
            <th>{{__('en.Id')}}</th>
            <th>{{__('en.Product Code')}}</th>
            <th>{{__('en.Name')}}</th>
            <th>{{__('en.Image')}}</th>
            <th>{{__('Cost price')}}</th>
            <th>{{__('en.Selling price')}}</th>
            <th>{{__('en.Stock')}}</th>
            <th>{{__('en.Stock alert')}}</th>
            <th>{{__('en.Action')}}</th>
        </tr>
    </thead>

    <tbody>
        @if ($products->count() > 0)

        @php

            if(request('page')>1)

            $counter = ((request('page')-1)*10) +1;
            else
            $counter = 1;
        @endphp
            @foreach ($products as $product )
                <tr id="recordrow{{$product->id}}"  @if($product->stock <= $product->stock_alert) class="align-middle bg-alert"  @endif>
                    <th>{{$counter}}</th>
                    <td>{{$product->product_code}}</td>
                    <td>{{$product->name}} <span class="badge bg-info text-dark">{{$product->variation}}</span></td>
                    <td>
                        {!! image('storage',$product->image,['class=" border border-1"','style="height: 40px; width: 40px !important"']) !!}
                    </td>
                    <td>{{auth()->user()->currency}} {{$product->price}}</td>
                    <td>{{auth()->user()->currency}} {{$product->sale_price}}</td>
                    <td>{{$product->stock}}</td>
                    <td>{{$product->stock_alert}}</td>
                    <td>
                        <div class="d-flex">
                        {{-- <a href="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"
                            class="box border bg-white border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary">
                            <i class="bi bi-eye-fill"></i></a> --}}
                        <a href="{{route('product.edit',$product->id)}}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"
                            class="box border bg-white border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary mx-2 ">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form class="" action="{{ route('product.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"  data-bs-toggle="tooltip" id="row{{$product->id}}" data-bs-placement="bottom" title="Delete"
                                class="box border bg-white border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary delete">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                        </div>
                    </td>
                </tr>
                @php
                $counter++;
            @endphp
            @endforeach
        @else
        <tr>
            <td class="text-center" colspan="9" >No record found</td>
        </tr>
        @endif
    </tbody>
</table>
