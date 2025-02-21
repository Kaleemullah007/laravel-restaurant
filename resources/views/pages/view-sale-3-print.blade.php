<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Invoice</title>

    <style>
        .invoice-box {
            max-width: 800px;
            min-height: 700px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="/images/{{ auth()->user()->logo }}" {{-- style="width: 100%; max-width: 300px" --}} />
                                <span class="" style="font-size: 28px">{{ auth()->user()->business_name }}</span>
                            </td>

                            <td>
                                Invoice # {{ $sales->id }}<br />
                                Date: {{ $sales->created_at->toFormattedDateString() }}<br />
                                Due Date: {{ $sales->created_at->toFormattedDateString() }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table cellpadding="0" cellspacing="0">
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr style="width: 100%">
                            <td style="width: 50%; text-align:left;">
                                {{ auth()->user()->business_name }}<br />
                                {{ auth()->user()->business_email }}<br />
                                {{ auth()->user()->business_phone }}<br />
                                {{ auth()->user()->address }},{{ auth()->user()->country }},{{ auth()->user()->postal_code }}
                            </td>

                            <td style="width: 50%; text-align:right;">
                                {{ $sales->Customer->name }}<br />
                                {{ $sales->Customer->email }}<br />
                                {{ $sales->Customer->phone }}<br />
                                {{ $sales->Customer->address }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
                    </table>

        <table cellpadding="0" cellspacing="0">
            <tr class="heading" style="width: 100%">
                <td style="width: 40%">Item</td>
                <td style="width: 20%; text-align:center;">Quantity</td>
                <td style="width: 20%; text-align:center;" >Price</td>
                <td style="width: 20%; text-align:center;">Amount</td>
            </tr>
            <tbody class="">
                {{-- <tr></tr> --}}
                @foreach ($sales->Products as $sale)
                    <tr class="item">
                        <td style="width: 40%" class="service">{{ $sale->product_name }}</td>
                        <td style="width: 20%; text-align:center;" class="qty">{{ $sale->qty }}</td>
                        <td style="width: 20%; text-align:center;" class="unit">{{ auth()->user()->currency }}{{ $sale->sale_price }}
                        </td>
                        <td style="width: 20%; text-align:center;" class="total">
                            {{ auth()->user()->currency }}{{ $sale->sale_price * $sale->qty }}
                        </td>
                    </tr>
                @endforeach
            </tbody>


            <table class="balance" align="right" style="width: 40%; margin-top:10px;">
                <tr>
                    <th><span >Sub-Total</span></th>
                    <td><span>{{ auth()->user()->currency }}{{ $sales->sub_total }}</span></td>

                </tr>
                <tr>
                    <th><span >Discount</span></th>
                    <td><span>{{ auth()->user()->currency }}{{ $sales->discount }}</span></td>
                </tr>
                <tr>
                    <th><span >Grand Total</span></th>
                    <td><span>{{ auth()->user()->currency }}{{ $sales->total }}</span></td>
                </tr>
                <tr>
                    <th><span >Amount Paid</span></th>
                    <td><span>{{ auth()->user()->currency }}{{ $sales->paid_amount }}</span></td>
                </tr>
                <tr>
                    <th><span >Balance Due</span></th>
                    <td><span>{{ auth()->user()->currency }}{{ $sales->remaining_amount }}</span></td>
                </tr>
            </table>
        </table>
    </div>
</body>

</html>
