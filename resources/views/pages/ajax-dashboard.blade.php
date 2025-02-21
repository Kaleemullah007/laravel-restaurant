@include('message')
<div class="sm-chart-sec mt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                <a href="{{ route('sale.index') }}" class="w-100">
                    <div class="revinue revinue-one_hybrid">
                        <div class="revinue-hedding">
                            <div class="w-title">
                                <div class="w-icon">
                                    <i class="bi bi-cart4"></i>
                                </div>
                                <div class="sm-chart-text">
                                    <p class="w-value">{{auth()->user()->currency}} {{$result['total_sales']}}</p>
                                    <h5>{{ __('dashboard.Sales')}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="revinue-content">
                            <div id="hybrid-followers"></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                <a href="{{ route('purchase.index') }}" class="w-100">
                    <div class="revinue page-one_hybrid">
                        <div class="revinue-hedding">
                            <div class="w-title">
                                <div class="w-icon">
                                    <i class="bi bi-receipt-cutoff"></i>
                                </div>
                                <div class="sm-chart-text">
                                    <p class="w-value">{{auth()->user()->currency}} {{$result['purchases_history']}}</p>
                                    <h5>{{ __('dashboard.Purchases')}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                <a href="{{ route('expense.index') }}" class="w-100">
                    <div class="revinue bounce-one_hybrid">
                        <div class="revinue-hedding">
                            <div class="w-title">
                                <div class="w-icon">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <div class="sm-chart-text">
                                    <p class="w-value">{{auth()->user()->currency}} {{$result['expenses']}}</p>
                                    <h5>{{ __('dashboard.Expenses')}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                {{-- <a href="{{ route('sale.index') }}" class="w-100"> --}}
                    <div class="revinue rv-status-one_hybrid">
                        <div class="revinue-hedding">
                            <div class="w-title">
                                <div class="w-icon">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="sm-chart-text">
                                    <p class="w-value">{{auth()->user()->currency}} {{$result['net_worth']}}</p>
                                    <h5>{{ __('dashboard.Net_Worth')}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- </a> --}}
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                {{-- <a href="{{ route('sale.index') }}" class="w-100"> --}}
                    <div class="revinue py-1 revinue-one_hybrid">
                        <div class="revinue-hedding">
                            <div class="w-title mt-1">
                                <div class="w-icon">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="sm-chart-text">
                                    <p class="w-value">{{ __('dashboard.Cash')}} : {{auth()->user()->currency}} {{$result['cash_in_hand']}}
                                    {{-- <h5>{{ __('dashboard.Cash')}}</h5> --}}
                                        <br>
                                    <span class="w-value">{{ __('dashboard.Other')}}: {{auth()->user()->currency}} {{$result['other_in_hand']}}</span>
                                    {{-- <h5>{{ __('dashboard.Other')}}</h5> --}}
                                    <br>
                                    <span class="w-value">{{ __('dashboard.Total')}}  :{{auth()->user()->currency}} {{$result['other_in_hand'] + $result['cash_in_hand']}}</span>
                                </p>


                                    
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- </a> --}}
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                {{-- <a href="{{ route('sale.index') }}" class="w-100"> --}}
                    <div class="revinue page-one_hybrid pt-2 pb-0">
                        <div class="revinue-hedding">
                            <div class="w-title">
                                <div class="w-icon ps-0 pe-2">
                                    <i class="bi bi-cash-stack fs-4"></i>
                                </div>
                                <div class="sm-chart-text">
                                    <h6>{{ __('dashboard.Remaining')}}</h6>
                                    <p class="w-value pt-1" >{{ __('dashboard.Customer')}} : {{auth()->user()->currency}} {{$result['remaining_amount']}}
                                      <br>
                                    <p class="w-value" >{{ __('purchases.vendor')}}: {{auth()->user()->currency}} {{$result['vendor_remainng']}}</p>
                                        
                                    {{-- <p class="w-value">{{auth()->user()->currency}} {{$result['remaining_amount']}}</p>
                                    <h5>{{ __('dashboard.Remaining')}}</h5>
                                    <p class="w-value">{{auth()->user()->currency}} {{$result['vendor_remainng']}}</p>
                                    <h5>{{ __('dashboard.Payable')}}</h5> --}}
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- </a> --}}
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                {{-- <a href="{{ route('sale.index') }}" class="w-100"> --}}
                    <div class="revinue bounce-one_hybrid">
                        <div class="revinue-hedding">
                            <div class="w-title">
                                <div class="w-icon">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="sm-chart-text">
                                    <p class="w-value">{{auth()->user()->currency}} {{$result['discount']}}</p>
                                    <h5>{{ __('dashboard.Discount')}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- </a> --}}
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 my-2">
                {{-- <a href="{{ route('sale.index') }}" class="w-100"> --}}
                    <div class="revinue rv-status-one_hybrid">
                        <div class="revinue-hedding">
                            <div class="w-title">
                                <div class="w-icon">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="sm-chart-text">
                                    <p class="w-value">{{auth()->user()->currency}} {{$result['net_profits']}}</p>
                                    <h5>{{ __('dashboard.Net_Profit')}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- </a> --}}
            </div>
        </div>
    </div>

    
</div>


@section('script')
<script>
    
     $(document).ready(function() {
        let getRandomColor =()=>{
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
            // Data passed from Laravel
            const monthlySalesData = @json($result['monthlySales']);

            // Prepare chart data
            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const datasets = monthlySalesData.map(user => {
                return {
                    label: user.name,
                    data: user.sales,
                    fill: true,
                    // borderColor: getRandomColor(),
                    tension: 0.1
                };
            });
 // Generate random color for each dataset
 
            // Chart.js configuration
            const ctx = document.getElementById('monthlySalesChart').getContext('2d');
            chart =   new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Monthly Sales for Each User'
                        },
                        tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return `$${tooltipItem.raw}`; // Format the tooltip to show currency
                    }
                }}
                    },
                    
                }
            });

           
        });


        function updateChart(newData) {
            chart.data.datasets = newData.map(user => ({
                label: user.name,
                data: user.sales,
                // borderColor: getRandomColor(),
                fill: false,
                tension: 0.1
            }));
            chart.update();
        }

</script>
@endsection
