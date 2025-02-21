<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="{{asset('style.css')}}" media="all" />

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous"> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css"> --}}

  </head>
  <body>
      <header class="clearfix">
        @if ($hide == true)
        <div class="row d-flex justify-content-between">
          <div class="col">
          <a href="{{ route('sale.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left-short"></i>Back</a>
        </div>
          <div class="col" id="logo">

            <img src="/images/{{auth()->user()->logo}}">


          </div>
          <div class="col">
            <form method="get" action="{{route('generate-pdf',$sales->id)}}">
                {{-- <button type="submit">Download!</button> --}}
                <button class="btn btn-success float-end"  ><i class="bi bi-printer me-2"></i>Print</button>
             </form>
            {{-- <button class="btn btn-success float-end"   onclick="printPageArea('printableArea')" ><i class="bi bi-printer me-2"></i>Print</button> --}}
          </div>
        </div>
        @endif

        <h1>INVOICE {{$sales->id}}</h1>
        <div id="company" class="clearfix">
          <div>{{auth()->user()->business_name}}</div>
          <div>{{auth()->user()->address}},<br /> {{auth()->user()->postal_code}}, {{auth()->user()->country}}</div>
          <div>{{auth()->user()->business_phone}}</div>
          <div><a href="mailto:{{auth()->user()->business_email}}">{{auth()->user()->business_email}}</a></div>
        </div>
        <div id="project">
          <div><span>Customer</span> Details</div>
          <div><span>Name -</span>{{$sales->Customer->name}}</div>
          <div><span>ADDRESS</span> {{$sales->Customer->address}}, {{$sales->Customer->address}}, {{$sales->Customer->address}}</div>
          <div><span>EMAIL</span> <a href="mailto:{{$sales->Customer->email}}">{{$sales->Customer->email}}</a></div>
          <div><span>DATE</span>{{$sales->created_at->toFormattedDateString()}}</div>
          <div><span>DUE DATE</span>{{$sales->created_at->toFormattedDateString()}}</div>
        </div>
      </header>
      <main>
        <table>
          <thead>
            <tr>
              <th class="service">Product Name</th>
              <th>PRICE</th>
              <th>QTY</th>
              <th>TOTAL</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($sales->Products as $sale )
            <tr>
              <td class="service">{{$sale->product_name}}</td>
              <td class="unit">{{auth()->user()->currency}}{{$sale->sale_price}}</td>
              <td class="qty">{{$sale->qty}}</td>
              <td class="total">{{auth()->user()->currency}}{{$sale->sale_price*$sale->qty}}</td>
            </tr>
            @endforeach

            <tr>
              <td colspan="3" class="text-alignment">SUBTOTAL</td>
              <td class="total ">{{auth()->user()->currency}}{{$sales->sub_total}}</td>
            </tr>
            
            <tr>
              <td colspan="3" class="text-alignment">Discount</td>
              <td class="total">{{auth()->user()->currency}}{{$sales->discount??0}}</td>
            </tr>
            <tr>
              <th colspan="3" class="text-end">{{ __('messages.Shipping') }}</th>
              <th class="text-end">{{auth()->user()->currency}}{{$sales->shipping??0}}</th>
          </tr>
            <tr>
              <td colspan="3" class="grand total text-alignment" >GRAND TOTAL</td>
              <td class="grand total">{{auth()->user()->currency}}{{$sales->total}}</td>
            </tr>
          </tbody>
        </table>
        <div id="notices">
          <div>{{auth()->user()->custom_note_heading}}</div>
          <div class="notice">{{auth()->user()->custom_note}}</div>
        </div>
      </main>
      <footer>
        Invoice was created on a computer and is valid without the signature and seal.
      </footer>
  </body>
</html>

