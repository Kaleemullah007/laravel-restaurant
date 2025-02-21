<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
        <link rel="stylesheet" href="{{asset('css/bootstrap-4.css')}}" media="all" />
        <link rel="stylesheet" href="{{asset('css/invoice1.css')}}" media="all" />


        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" --}}
        {{-- integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"> --}}
    {{-- </script> --}}

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css"> --}}
    {{-- <link href="/assets/font.css" rel="stylesheet" /> --}}



</head>

<body>


    <div class="page-content container">
        @if (!isset($hide))
        <div class="row d-flex justify-content-between">
            <div class="col">
            <a href="{{ route('sale.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left-short"></i>Back</a>
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

        <div class="page-header text-blue-d2">
            <h1 class="page-title text-secondary-d1">
                Invoice
                <small class="page-info">
                    <i class="fa fa-angle-double-right text-80"></i>
                    {{ $sales->id }}
                </small>
            </h1>

            <div class="page-tools">

                <div class="action-buttons">
                  {{-- <a class="btn bg-white btn-light mx-1px text-95" href="#" data-title="Back">
                        <i class="bi bi-arrow-left-short"></i>Back
                    </a> --}}
                    {{-- <a class="btn bg-white btn-light mx-1px text-95" href="#" data-title="Print">
                        <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                        Print
                    </a> --}}
                    {{-- <a class="btn bg-white btn-light mx-1px text-95" href="#" data-title="PDF">
                        <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
                        Export
                    </a> --}}
                </div>
            </div>
        </div>

        <div class="container px-0">
            <div class="row mt-4">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center text-150">
                                <div class="col" id="logo">
                                    {{-- <img src="{{public_path().'/logo.png'}}"> --}}
                                    <img src="/images/{{auth()->user()->logo}}">
                                </div>
                                <span class="text-default-d3">{{ auth()->user()->business_name }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- .row -->

                    <hr class="row brc-default-l1 mx-n1 mb-4" />

                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <span class="text-sm text-grey-m2 align-middle">To:</span>
                                <span
                                    class="text-600 text-110 text-blue align-middle">{{ $sales->Customer->name }}</span>
                            </div>
                            <div class="text-grey-m2">
                                <div class="my-1">
                                    {{ $sales->Customer->address }}
                                </div>
                                {{-- <div class="my-1">
                                    State, Country
                                </div> --}}
                                <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i>
                                    <b class="text-600">{{ $sales->Customer->phone }}</b>
                                </div>
                                <div class="my-1"><i class="bi bi-envelope"></i>
                                    <b class="text-600"> <a
                                            href="mailto:{{ $sales->Customer->email }}">{{ $sales->Customer->email }}</a></b>
                                </div>
                                <div class="my-1"><span class=" text-600 text-90">Date:</span>
                                    {{ $sales->created_at->toFormattedDateString() }}
                                </div>
                                <div class="my-1"><span class=" text-600 text-90">Due Date:</span>
                                    {{ $sales->created_at->toFormattedDateString() }}
                                </div>

                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                            <hr class="d-sm-none" />
                            <div class="text-grey-m2">
                                <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                    {{ auth()->user()->business_name }}
                                </div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Email: </span><a
                                        href="mailto:{{ auth()->user()->business_email }}">{{ auth()->user()->business_email }}</a>
                                </div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Phone:</span> {{ auth()->user()->business_phone }}
                                </div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Address:</span>
                                    {{ auth()->user()->address }},{{ auth()->user()->country }},{{ auth()->user()->postal_code }}
                                </div>


                                {{-- <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Status:</span> <span
                                        class="badge badge-warning badge-pill px-25">Unpaid</span></div> --}}
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="mt-4">
                        {{-- <div class="row text-600 text-white bgc-default-tp1 py-25">
                            <div class="d-none d-sm-block col-1">#</div>
                            <div class="col-9 col-sm-5">Description</div>
                            <div class="d-none d-sm-block col-4 col-sm-2">Qty</div>
                            <div class="d-none d-sm-block col-sm-2">Unit Price</div>
                            <div class="col-2">Amount</div>
                        </div>

                        <div class="text-95 text-secondary-d3">
                            <div class="row mb-2 mb-sm-0 py-25">
                                <div class="d-none d-sm-block col-1">1</div>
                                <div class="col-9 col-sm-5">Domain registration</div>
                                <div class="d-none d-sm-block col-2">2</div>
                                <div class="d-none d-sm-block col-2 text-95">$10</div>
                                <div class="col-2 text-secondary-d2">$20</div>
                            </div>

                        </div>

                        <div class="row border-b-2 brc-default-l2"></div> --}}

                        <!-- or use a table instead -->

                        <div class="table-responsive">
                            <table class="table table-striped table-borderless border-0 border-b-2 brc-default-l1">
                                <thead class="bg-none bgc-default-tp1">
                                    <tr class="text-white">
                                        <th class="opacity-2 ">#</th>
                                        <th class="service">Product</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <th width="140">Amount</th>
                                    </tr>
                                </thead>

                                <tbody class="text-95 text-secondary-d3">
                                    <tr></tr>
                                    @foreach ($sales->Products as $sale)
                                        <tr>
                                            <td class="id">{{ $sale->id }}</td>
                                            <td class="service">{{ $sale->product_name }}</td>
                                            <td class="qty">{{ $sale->qty }}</td>
                                            <td class="unit">{{ auth()->user()->currency }}{{ $sale->sale_price }}
                                            </td>
                                            <td class="total">
                                                {{ auth()->user()->currency }}{{ $sale->sale_price * $sale->qty }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-3 d-flex justify-content-end">
                            {{-- <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                                Extra note such as company or payment information...
                            </div> --}}

                            <div class="col-4 col-sm-5 text-grey text-90 order-first order-sm-last">
                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        SubTotal
                                    </div>
                                    <div class="col-5">
                                        <span
                                            class="text-120 text-secondary-d1">{{ auth()->user()->currency }}{{ $sales->sub_total }}</span>
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        Discount
                                    </div>
                                    <div class="col-5">
                                        <span
                                            class="text-110 text-secondary-d1">{{ auth()->user()->currency }}{{ $sales->discount }}</span>
                                    </div>
                                </div>

                                <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                    <div class="col-7 text-right">
                                        Total Amount
                                    </div>
                                    <div class="col-5">
                                        <span
                                            class="text-150 text-success-d3 opacity-2">{{ auth()->user()->currency }}{{ $sales->total }}</span>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        Paid Amount
                                    </div>
                                    <div class="col-5">
                                        <span
                                            class="text-110 text-secondary-d1">{{ auth()->user()->currency }}{{ $sales->paid_amount }}</span>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        Remaining Amount
                                    </div>
                                    <div class="col-5">
                                        <span
                                            class="text-110 text-secondary-d1">{{ auth()->user()->currency }}{{ $sales->remaining_amount }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <div>
                            <span class="text-secondary-d1 text-105">Thank you for being our Customer</span>
                            {{-- <a href="#" class="btn btn-info btn-bold px-4 float-right mt-3 mt-lg-0">Pay Now</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
