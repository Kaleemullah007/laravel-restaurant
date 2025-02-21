<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.invoice') }}{{$sales->serial_series??''}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #invoice, #invoice * {
                visibility: visible;
            }

            #invoice {
                /* position: absolute; */
                /* left: 0; */
                /* top: 0; */
                /* width: 80mm; 80mm width for thermal printer */
                /* padding-top: 10px; */
                font-size: 12px;
            }

            /* hr {
                border-top: 1px dashed #000;
            } */
        }
    </style>
</head>
<body >
<!-- Invoice Template -->
<div id="invoice" class="container">
    <div class="text-center pt-4">
        <div class="row justify-content-center">
            <div class="col-2 ">
                        <img src="/images/{{auth()->user()->logo}}">
            </div>

        </div>
        <h4 class="fw-bold">{{auth()->user()->business_name}}</h4>
        <p class="mb-1">{{auth()->user()->address}},</p>
        <p class="mb-1">{{auth()->user()->country}}  {{auth()->user()->postal_code}}</p>
        <p class="mb-3">{{auth()->user()->business_phone}} , {{auth()->user()->email}}</p>
    </div>
    <hr class="my-2">
    <div class="mb-2">
        <p class="mb-1"><strong>{{ __('messages.date') }}:</strong> {{$sales->created_at->toFormattedDateString()}}</p>
        <p class="mb-1"><strong>{{ __('messages.invoice') }} #</strong> {{$sales->serial_series}}</p>
        <p class="mb-1"><strong>{{ __('messages.customer') }}:</strong> {{$sales->Customer->name}}</p>
    </div>
    <hr class="my-2">
    <table class="table table-bordered table-sm">
        <thead class="table-light">
            <tr>
                <th>{{ __('messages.product') }}</th>
                <th class="text-end">{{ __('messages.quantity') }}</th>
                <th class="text-end">{{ __('messages.price') }}</th>
                <th class="text-end">{{ __('messages.total') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales->Products as $sale )
            <tr>
              <td class="service">{{$sale->product_name}}</td>
              <td class="qty text-end">{{$sale->qty}}</td>
                <td class="unit text-end">{{auth()->user()->currency}}{{$sale->sale_price}}</td>
              <td class="total text-end">{{auth()->user()->currency}}{{$sale->sale_price*$sale->qty}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">{{ __('messages.Sub-Total') }}</th>
                <th class="text-end">{{auth()->user()->currency}}{{$sales->sub_total}}</th>
            </tr>
            <tr>
                <th colspan="3" class="text-end">{{ __('messages.Tax') }}</th>
                <th class="text-end">{{auth()->user()->currency}}{{$sales->tax_amount??0}}</th>
            </tr>
            <tr>
                <th colspan="3" class="text-end">{{ __('messages.Discount') }}</th>
                <th class="text-end">{{auth()->user()->currency}}{{$sales->discount??0}}</th>
            </tr>
            <tr>
                <th colspan="3" class="text-end">{{ __('messages.Remaining') }}</th>
                <th class="text-end">{{auth()->user()->currency}}{{$sales->remaining_amount??0}}</th>
            </tr>
            <tr>
                <th colspan="3" class="text-end">{{ __('messages.Shipping') }}</th>
                <th class="text-end">{{auth()->user()->currency}}{{$sales->shipping??0}}</th>
            </tr>
            <tr>
                <th colspan="3" class="text-end">{{ __('messages.Grand Total') }}</th>
                <th class="text-end">{{auth()->user()->currency}}{{$sales->total}}</th>
            </tr>
        </tfoot>
    </table>
    <hr class="my-2">
    <div class="text-center">
        <p>{{ __('messages.thankyou') }}!</p>
    </div>
</div>

</body>
</html>
