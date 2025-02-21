<?php

namespace App\Http\Controllers;

use App\Models\DepositHistory;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseHistory;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Raw;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $admin_id;

    public function __construct()
    {

        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function welcome()
    {

        return view('welcome');
    }

    public function chart()
    {

        // Sample Users
        $users = [
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
            ['id' => 3, 'name' => 'Charlie'],
        ];

        // Sample Products
        $products = [
            ['id' => 1, 'name' => 'Laptop', 'price' => 1000],
            ['id' => 2, 'name' => 'Phone', 'price' => 500],
            ['id' => 3, 'name' => 'Tablet', 'price' => 300],
        ];

        // Sample Orders
        $orders = [
            ['user_id' => 1, 'product_id' => 1, 'quantity' => 1, 'date' => '2023-01-15'],
            ['user_id' => 1, 'product_id' => 2, 'quantity' => 2, 'date' => '2023-01-25'],
            ['user_id' => 2, 'product_id' => 2, 'quantity' => 1, 'date' => '2023-02-05'],
            ['user_id' => 2, 'product_id' => 3, 'quantity' => 3, 'date' => '2023-02-15'],
            ['user_id' => 3, 'product_id' => 1, 'quantity' => 1, 'date' => '2023-03-12'],
            // Additional orders to show monthly variation
        ];

        // Process data to get monthly sales for each user
        $monthlySales = [];
        foreach ($users as $user) {
            $userSales = [];
            foreach (range(1, 12) as $month) {
                $monthTotal = 0;
                foreach ($orders as $order) {
                    if ($order['user_id'] == $user['id'] && Carbon::parse($order['date'])->month == $month) {
                        // Calculate total price for the order
                        $product = collect($products)->firstWhere('id', $order['product_id']);
                        $monthTotal += $product['price'] * $order['quantity'];
                    }
                }
                $userSales[] = $monthTotal;
            }
            $monthlySales[] = [
                'name' => $user['name'],
                'sales' => $userSales,
            ];
        }

        return $monthlySales;

    }

    public function index(Request $request)
    {

        $user = Auth::user();

        if ($user) {
            if ($user->user_type == 'employee') {
                return redirect()->route('pos');
            }

        }

        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d');
        $result = $this->dashboardStat($start_date, $end_date);

        $admins = User::where('user_type', 'admin')->get();
        $flag = false;
        if ($request->ajax()) {
            $flag = true;
        }

        return view('pages.dashboard', compact('result', 'admins', 'flag'));
    }

    public function getDashboard(Request $request)
    {
        if (isset($request->admin_id) && $request->admin_id != 'all') {
            session()->put('admin_id', $request->admin_id);
        } elseif ($request->admin_id == 'all') {
            session()->forget('admin_id');
        }
        // dd(session()->get('admin_id'), $request->admin_id);

        $dates = $request->daterange;
        [$start_date, $end_date] = explode('-', $dates);
        $start_date = changeDateFormat($start_date, 'Y-m-d');
        $end_date = changeDateFormat($end_date, 'Y-m-d');
        $result = $this->dashboardStat($start_date, $end_date);
        $flag = false;
        if ($request->ajax()) {
            $flag = true;
        }
        $dashboard_html = view('pages.ajax-dashboard', compact('result', 'flag'))->render();
        $dashboard_latest_html = view('pages.ajax-dashboard-latest', compact('result', 'flag'))->render();

        // session()->forget('admin_id');
        // dd($result);
        return response()->json(['html' => $dashboard_html, 'latest_html' => $dashboard_latest_html, 'monthlySalesData' => $result['monthlySales']]);

    }

    public function dashboardStat($start_date, $end_date)
    {

        $testers = User::where('is_tester', 1)->get()->pluck('id')->toArray();

        if (session()->has('admin_id')) {
            if (in_array(session()->get('admin_id'), $testers)) {

                $testers = [];
            }
        }
        // dd($testers);

        // $testers = array();

        $users = User::withoutGlobalScope('filter_by_user')->leftjoin('sales', 'users.id', '=', 'sales.owner_id');
        if (auth()->user()->user_type == 'admin') {
            $users = $users->where('users.id', auth()->user()->id);
        } elseif (session()->has('admin_id') && auth()->user()->user_type == 'superadmin') {
            $users = $users->where('users.id', session()->get('admin_id'));
        }

        if (! empty($testers)) {
            $users = $users->where('is_tester', 0);
        }

        $users = $users->where('user_type', 'admin')
            ->where('user_type', '!=', 'superadmin')
            ->whereDate('sales.created_at', '>=', $start_date)
            ->whereDate('sales.created_at', '<=', $end_date);
        $users = $users->select(
            'users.name as name',
            DB::raw('MONTH(sales.created_at) - 1 as month'), // Adjust month to 0-indexed
            DB::raw('SUM(sales.total) as total_amount')
        )
            ->groupBy('users.name', DB::raw('MONTH(sales.created_at) - 1')) // Adjust groupBy for month alias
            ->orderBy('users.id')
            ->get();
        // dd($users);

        // Step 2: Format the data into the required structure
        $report_data = [];

        foreach ($users->groupBy('name') as $userName => $sales) {
            $monthlyTotals = array_fill(0, 12, 0); // Initialize 12 months with 0

            foreach ($sales as $sale) {
                if (! is_null($sale->month)) {
                    $monthlyTotals[$sale->month] = $sale->total_amount;
                } // Set the correct month
            }

            $report_data[] = [
                'name' => $userName,
                'sales' => $monthlyTotals,
            ];
        }

        $monthlySales = $report_data;
        // dd($result,$this->chart());

        $expenses = Expense::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date);
        if (! empty($testers)) {
            $expenses = $expenses->whereNotIn('owner_id', $testers);
        }
        $expenses = $expenses->sum('amount');

        // dd($expenses);
        $latest_expenses = Expense::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date);
        if (! empty($testers)) {
            $latest_expenses = $latest_expenses->whereNotIn('owner_id', $testers);
        }

        $latest_expenses = $latest_expenses->take(10)
            ->latest()
            ->get();

        // $products = Product::withSum(['SaleProduct'
        //         =>function($query) use($start_date,$end_date){
        //             $query->whereDate('created_at','>=',$start_date)->whereDate('created_at','<=',$end_date);
        //         }],
        //         'total')
        //         ->withSum(['ProductionProduct'
        //         =>function($query) use($start_date,$end_date){
        //             $query->whereDate('created_at','>=',$start_date)->whereDate('created_at','<=',$end_date);
        //         }],'qty')
        //         ->get();

        $sales = Sale::query()
        // ->Sum('cost_total')
        // ->Sum('total')
        // ->Sum('total_qty')
            ->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
        // ->sum('total')
        // ->sum('discount')
        // ->sum('remaning_amount')
        // ->sum('paid_amount')

        if (! empty($testers)) {
            $sales = $sales->whereNotIn('owner_id', $testers);
        }

        $sales = $sales->get();

        // dd($sales);

        $products_sum_cost_price = $sales->sum('cost_total');
        $products_sum_sale_price = $sales->sum('total');
        $products_sum_qty = $sales->sum('total_qty');
        $total = $sales->sum('total');
        $discount = $sales->sum('discount');
        $paid_amount = $sales->sum('paid_amount');
        $remaining_amount = $sales->sum('remaining_amount');
        $cost_total = $sales->sum('cost_total');
        $total_qty = $sales->sum('total_qty');
        $tax_amount = $sales->sum('tax_amount');
        $shipping = $sales->sum('shipping');
        $cash_in_hand = $sales->where('payment_method', 'Cash')->sum('paid_amount');

        $other_in_hand = $sales->where('payment_method', '!=', 'Cash')->sum('paid_amount');

        $sub_total_cost = $sales->sum('sub_total_cost');
        $cost_total = $sales->sum('cost_total');

        $amount = DepositHistory::query()
            ->join('users', 'deposit_histories.user_id', '=', 'users.id');
        if (! empty($testers)) {
            $amount = $amount->whereNotIn('user_id', $testers);
        }

        // if(auth()->user()->user_type == 'admin'){
        //     $amount = $amount->where('users.owner_id', auth()->user()->user_id);
        // }

        $amount = $amount->get();
        $vendor_remaining = $amount->where('user_type', 'vendor')->sum('amount');
        $amount = $amount->where('user_type', 'customer')->sum('amount');
        // $amount=$amount->sum('amount');

        // dd($vendor_remaining,$amount);

        $remaining_amount = Sale::query();
        if (! empty($testers)) {
            $remaining_amount = $remaining_amount->whereNotIn('owner_id', $testers);
        }

        $remaining_amount = $remaining_amount
            ->sum('remaining_amount');

        $remaining_amount = $remaining_amount - $amount;

        $products_sum_sale_price = Sale::query();

        if (! empty($testers)) {
            $products_sum_sale_price = $products_sum_sale_price->whereNotIn('owner_id', $testers);
        }

        $products_sum_sale_price = $products_sum_sale_price->sum('total');

        // purchases_history
        $purchases_history = Purchase::query();
        if (! empty($testers)) {
            $purchases_history = $purchases_history->whereNotIn('owner_id', $testers);
        }

        $remain_payable = $purchases_history->sum(DB::raw('remaining_amount'));
        // dd($remain_payable);
        $vendor_remainng = $remain_payable - $vendor_remaining;
        // dd($vendor_remainng,$remaining_amount);

        $purchases_history = $purchases_history->sum(DB::raw('price*qty'));

        $latest_sales = Sale::query()
            ->with(['Customer', 'Products'])
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date);
        if (! empty($testers)) {
            $latest_sales = $latest_sales->whereNotIn('owner_id', $testers);
        }

        $latest_sales = $latest_sales->take(10)
            ->latest()
            ->get();

        $latest_products = Product::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date);

        if (! empty($testers)) {
            $latest_products = $latest_products->whereNotIn('owner_id', $testers);
        }

        $latest_products = $latest_products->take(10)
            ->latest()->get();

        $users = User::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->WhereNotIn('user_type', ['vendor']);

        if (! empty($testers)) {
            $users = $users->whereNotIn('owner_id', $testers);
        }

        $users = $users->take(10)
            ->latest()
            ->get();

        $latest_purchases = Purchase::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date);
        if (! empty($testers)) {
            $latest_purchases = $latest_purchases->whereNotIn('owner_id', $testers);
        }

        $latest_purchases = $latest_purchases->whereNotIn('owner_id', $testers)
            ->take(10)->latest()->get();

        $purchases_history = PurchaseHistory::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date);
        if (! empty($testers)) {
            $purchases_history = $purchases_history->whereNotIn('owner_id', $testers);
        }

        $purchases_history = $purchases_history->latest()->sum(DB::raw('price*qty'));

        $total_sales = $products_sum_sale_price; // $sales->sum('sale_product_sum_total');
        $total_purchases_qty = $sales->sum('production_product_sum_qty');

        $net_worth = $purchases_history - $total_sales;

        if ($net_worth > 0) {
            $net_worth = $net_worth - $expenses;
        } else {
            $net_worth = $net_worth + $expenses;
        }

        $net_profit = $total - $cost_total - $shipping - $tax_amount - $expenses;

        // $salesData = SaleProduct::join('sales', 'sale_products.sale_id', '=', 'sales.id')

        //     ->select(
        //         DB::raw('DATE_FORMAT(sales.created_at, "%Y-%m") as month'), // Format as "YYYY-MM"
        //         'sale_products.product_name',
        //         DB::raw('SUM(sale_products.qty) as total_sold')
        //     )
        //     ->whereBetween('sales.created_at', [Carbon::parse($start_date.' 00:00:00'), Carbon::parse($end_date.' 23:59:59')])
        //     ->groupBy('month', 'product_name')
        //     ->orderBy('month')
        //     ->get();
        // $chartData = [
        //     'months' => $salesData->pluck('month')->unique()->values(), // Unique months in order
        //     'datasets' => $salesData->groupBy('name')->map(function ($data, $product) {
        //         return [
        //             'label' => $product,
        //             'data' => $data->pluck('total_sold'), // Sales data for each product
        //             // 'backgroundColor' => $this->randomColor(), // Assign random colors
        //             // 'borderColor' => $this->randomColor(),
        //             'borderWidth' => 1
        //         ];
        //     })->values() // Convert the collection to an array
        // ];
        // dd($salesData,[$startDate->format('Y-m-d'),$endDate->format('Y-m-d'),Carbon::parse($start_date)->format('Y-m-d'), Carbon::parse($end_date)->format('Y-m-d')]);

        //    dd($total , $cost_total ,$discount, $tax_amount,$shipping ,$expenses);
        return [
            'latest_products' => $latest_products,
            'users' => $users,
            'latest_purchases' => $latest_purchases,
            'latest_sales' => $latest_sales,
            'products' => $sales,
            'latest_expenses' => $latest_expenses,
            'expenses' => $expenses,
            'total_sales' => $total_sales,
            'total_purchases_qty' => $total_purchases_qty,
            'purchases_history' => $purchases_history,
            'net_profits' => $net_profit,
            'net_worth' => $net_worth,
            'vendor_remainng' => $vendor_remainng,
            'products_sum_cost_price' => $products_sum_cost_price,
            'products_sum_sale_price' => $products_sum_sale_price,
            'products_sum_qty' => $products_sum_qty,
            'total' => $total,
            'discount' => $discount,
            'paid_amount' => $paid_amount,
            'remaining_amount' => $remaining_amount,
            'cost_total' => $cost_total,
            'total_qty' => $total_qty,
            'cash_in_hand' => $cash_in_hand,
            'other_in_hand' => $other_in_hand,
            'monthlySales' => $monthlySales,
            // 'chartData'=>$chartData

        ];
    }

    public function changeLang($langcode)
    {

        App::setLocale($langcode);
        session()->put('lang_code', $langcode);

        return redirect()->back();
    }

    public function POS()
    {
        return view('pages.pos');
    }
}
