<option>{{ __('en.Choose') }}</option>
@foreach ($products as $product)


    <option value="{{ $product->id }}" @if (in_array($product->id,$add_products))
        style="{{'color:red'}}"
        @endif>{{ $product->name }} <span class="badge bg-info text-dark">{{$product->variation}}</span></option>
@endforeach
