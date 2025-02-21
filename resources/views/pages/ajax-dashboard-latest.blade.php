<div class="all-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12 pt-4">
                <div class="admin-list">
                    <a href="{{route('purchase.index')}}">
                        <p class="admin-ac-title ">{{__('dashboard.Purchases')}}</p>
                    </a>
                    <div class="table-responsive">
                        <table class="table border table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('dashboard.Id') }}</th>
                                    <th>{{ __('dashboard.Name') }}</th>
                                    <th>{{ __('dashboard.Quantity') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result['latest_purchases'] as $purchase)
                                    <tr>
                                        <th>{{ $purchase->id }}</th>
                                        <td>{{ $purchase->name }}</td>
                                        <td>{{ $purchase->qty }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 pt-4">
                <div class="admin-list">
                    <a href="{{route('sale.index')}}">
                        <p class="admin-ac-title">{{__('dashboard.Sales')}}</p>
                    </a>
                    <div class="table-responsive">
                        <table class="table border table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('dashboard.Id')}}</th>
                                    <th>{{__('dashboard.Customer')}}</th>
                                    <th>{{__('dashboard.Product')}}</th>
                                    <th>{{__('dashboard.Quantity')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result['latest_sales'] as $sale )
                              
                                <tr>
                                    <th>{{$sale->id}}</th>
                                    <td>{{$sale->Customer->name}}</td>
                                    <td>{{$sale->Products->pluck('product_name')->join(',')}}</td>
                                    <td>{{$sale->total_qty}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 pt-4">
                <div class="admin-list">
                    <a href="{{route('expense.index')}}">
                        <p class="admin-ac-title">{{__('dashboard.Expenses')}}</p>
                    </a>
                    <div class="table-responsive">
                        <table class="table border table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('dashboard.Id')}}</th>
                                    <th>{{__('dashboard.Name')}}</th>
                                    <th>{{__('dashboard.Amount')}}</th>
                                    <th>{{__('dashboard.Date')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result['latest_expenses'] as $expense )
                                    <tr>
                                        <th>{{$expense->id}}</th>
                                        <td>{{$expense->name}}</td>
                                        <td>{{auth()->user()->currency}} {{$expense->amount}}</td>
                                        <td>{{$expense->date}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>