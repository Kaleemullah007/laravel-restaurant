@foreach ($products as $product)
<div class="col-sm-2 mt-2">
    <div class="card rounded border-1 border-dark pb-3" id="original_product{{ $product->id }}"
        onclick="addProductToCart({{ $product->id }})" style="height: 100% !important">
        {{-- <img src="/assets/images/img7.png" class="card-img-top position-relative" alt="..."> --}}
        {!! image('storage', $product->image, [
            'class="card-img-top position-relative"',
            'style="height: 80px !important"',
        ]) !!}
        <span class="position-css-1 badge fw-light rounded-pill bg-dark "
            id="stock_product{{ $product->id }}">{{ $product->stock }}</span>
        <input type="hidden" id="original_stock_product{{ $product->id }}"
            value="{{ $product->stock }}" />
        {{-- <div class="card-body-- px-1 pb-1">
                <span>{{ $product->name }}</span><br>
                <span>{{ $product->product_code }}</span><br>
                
                <h5 class="badge fs-6 mb-0 fw-light bg-success text-white " style="margin-bottom: 10px !important">{{ auth()->user()->currency }}
                    {{ $product->price }}</h5>
            </div> --}}
        <div class="card-body position-relative px-1 pt-0 mt-0">
            <span class="fw-bold">{{ $product->product_code }}</span><br>
            <span class="">{{ $product->name }}<span class="badge bg-info text-dark">{{$product->variation}}</span></span>
            <h5 class="badge fs-6 fw-light bg-success text-white position-absolute text-wrap"
                style="top: 80%;left: 3%;">
                {{ auth()->user()->currency }} {{ $product->sale_price }}
            </h5>
        </div>


    </div>
</div>
{{-- <div class="col-sm-2">
    <div class="card rounded border-1 border-dark" id="original_product{{$product->id}}" onclick="addProductToCart({{$product->id}})">
        
        {!! image('storage', $product->image, [
            'class="card-img-top position-relative"',
            'style="height: 80px !important"',
        ]) !!}
        <span class="position-css-1 badge rounded-pill bg-cyan fw-bold" id="stock_product{{$product->id}}">{{$product->stock}}</span>
        <input type="hidden" id="original_stock_product{{$product->id}}" value="{{$product->stock}}" />
        <div class="card-body pb-1">
            <span>{{$product->name}}</span><br>
            <span>{{$product->product_code}}</span><br>
            <h5 class="badge bg-success text-white ">{{ auth()->user()->currency}} {{$product->price}}</h5>
        </div>
    </div>
</div> --}}
@endforeach