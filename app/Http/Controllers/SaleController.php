<?php

namespace App\Http\Controllers;

use App\DataTables\SaleDataTable;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Mail\SaleEmail;
use App\Mail\SendInvoice;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\OrderStatus;
use App\Models\OrderType;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function __construct()
    {

        $this->middleware(['auth', 'verified']);
    }

    public function index(SaleDataTable $dataTable)
    {

        // dd(Sale::with(['customer', 'products'])->get());
        $customer_id = request()->query('customer_id', null);
        $currentPage = request()->query('page', 1);

        return $dataTable
            ->with('currentPage', $currentPage)
            ->with('customer_id', $customer_id)
            ->render('sales.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index1(Request $request)
    {

        $sales = $this->recordsQuery($request)->paginate(config('services.per_page', 10));
        $customers = User::where('user_type', 'customer')->get();
        if ($sales->lastPage() >= request('page')) {
            return view('pages.sale', compact('sales', 'customers'));
        }

        return to_route('sale.index', ['page' => $sales->lastPage()]);
    }

    public function CSV(Request $request)
    {

        $sales = $this->recordsQuery($request)->get();
        $fileName = 'Sale Detail Report.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['', 'Customer Name', 'Product Name', 'Sale Price', 'Qty', 'Stock', 'Discount', 'Price'];

        $callback = function () use ($sales, $columns) {

            $sale_price = 0;
            $total_qty = 0;
            $total_stock = 0;
            $total_discount = 0;
            $total_price = 0;
            $file = fopen('php://output', 'w');
            fputcsv($file, [' ', ' ', ' ', 'Sale Detail Report']);
            fputcsv($file, $columns);

            foreach ($sales as $key => $sale) {
                $orders = [];
                $sale_price += $sale->sale_price;
                $total_qty += $sale->qty;
                $total_stock += $sale->stock;
                $total_discount += $sale->discount;
                $total_price += $sale->price;

                $orders = [
                    '',
                    $sale->Customer->name,
                    $sale->Product->name,
                    $sale->sale_price,
                    $sale->qty,
                    $sale->stock,
                    $sale->discount,
                    $sale->price,
                ];
                fputcsv($file, $orders);
            }

            $columns = ['', '', '', '', '', '', '', ''];
            $columns = ['', '', '', '', '', '', '', ''];
            $columns = ['', '', '', '', '', '', '', ''];
            $columns = ['', '', '', '', '', '', '', ''];
            fputcsv($file, $columns);

            $columns = ['', '', '', $sale_price, $total_qty, $total_stock, $total_discount, $total_price];
            fputcsv($file, $columns);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function recordsQuery($request)
    {
        // withoutGlobalScopes()->
        $dates = $request->daterange;
        $search = $request->search;

        $customer_id = $request->customer_id ?? null;
        $sales = Sale::with(['Customer', 'Product', 'Products']);
        if ($dates != null) {
            [$start_date, $end_date] = explode('-', $dates);

            $start_date = changeDateFormat($start_date, 'Y-m-d');
            $end_date = changeDateFormat($end_date, 'Y-m-d');
            $sales = $sales->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date);
        } else {
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-d');
            $sales = $sales->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date);
        }

        if ($customer_id != null && $customer_id != 'Choose Customer') {
            $sales = $sales->where('user_id', $customer_id);
        }

        if ($search != null) {

            $sales = $sales->whereHas('Product', function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%');
            });
            $sales = $sales->orWhereHas('Customer', function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%');
            });

            return $sales;
        }

        return $sales->orderBy('created_at', 'DESC');
    }

    public function getSales(Request $request)
    {

        $sales = $this->recordsQuery($request)->get();
        $sale_html = view('pages.ajax-sale', compact('sales'))->render();
        $pagination_html = view('pages.pagination', compact('sales'))->render();

        return response()->json(['html' => $sale_html, 'phtml' => $pagination_html]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $products = Product::where('stock', '>', 0)->get();
        $customers = User::where('owner_id', auth()->id())
            ->where('user_type', 'customer')
            ->get();

        return view('pages.create-sale', compact('products', 'customers'));
    }

    //  Pos

    /**
     * Show the form for creating a new resource.
     */
    public function pos(): View
    {
        // dd(Carbon::now()->format('Y-m-d H:i:s'));
        $sale = Sale::with('Products', 'Customer')->latest()->first();
        $hide = true;
        $currentDateTime = Carbon::now();

        $products = Product::where('status', 1)
            ->where(function ($query) use ($currentDateTime) {
                $query->where(function ($q) {
                    // Regular in-stock deals
                    $q->where('stock', '>', 0)
                        ->where('is_deal', 1)
                        ->where('status', 1);
                })
                    ->orWhere(function ($q) use ($currentDateTime) {
                        // Non-deal products with valid time range
                        $q->where('is_deal', 0)
                            ->where(function ($timeQ) use ($currentDateTime) {
                                $timeQ->where(function ($normalQ) use ($currentDateTime) {
                                    $normalQ->where('start_time', '<=', $currentDateTime)
                                        ->where('end_time', '>', $currentDateTime)->where('status', 1);
                                })
                                    ->orWhere('is_always', 1);
                            });
                    });
            })
            ->latest()
            ->get();
        // $deals = Deal::where('status', true)
        // // ->whereDate('start_time', '<=', Carbon::now())
        // //     ->whereDate('end_time', '>=', Carbon::now())
        //     ->latest()->get();
        $customers = Customer::where('user_type', 'customer')
            ->get();

        return view('pages.pos', compact('products', 'customers', 'sale'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {

        // $sale = Sale::first();
        // $cusomer_email = $sale->customer->email??null;
        // if(!is_null($cusomer_email))
        // Mail::to($cusomer_email)->send(new SaleEmail($sale));
        // dd("ss");
        // dd($request->is_edit);

        // dd( $filtered);
        if (! is_null($request->sale_id) && $request->is_edit == true) {
            $filtered = array_filter($request->products, function ($item) {
                if (! isset($item['product_status'])) {
                    return false;
                }

                return in_array($item['product_status'], ['D', 'E']);
            });
            // dd( $filtered);
            if ($this->updateStock($request->sale_id)) {
                $sale = Sale::with('products')->where('id', $request->sale_id)->first();

                if (! is_null($sale)) {
                    if ($sale->products()->count() > 0) {
                        $sale->products()->delete();
                    }

                    $sale->delete();

                }

                $productIds = collect($filtered)->pluck('product_id');

                $DBProducts = Product::find($productIds)
                    ->keyBy('id');
                foreach ($filtered as $index => $filter) {
                    if (! isset($DBProducts[$filter['product_id']])) {
                        continue;
                    }

                    $purchase_history_id = 0;
                    $ProductPurchase = Purchase::where('product_id', $filter['product_id'])->get();
                    if ($ProductPurchase->count() == 1) {
                        $purchase_history_id = $ProductPurchase[0]->id;
                    }
                    // $DBProducts[$filter['product_id']]->increment('stock', $filter['qty']);

                    PurchaseReturn::create([
                        'product_id' => $filter['product_id'],
                        'product_name' => $DBProducts[$filter['product_id']]->name,
                        'owner_id' => $request->owner_id,
                        'quantity' => $filter['qty'],
                        'unit_price' => $DBProducts[$filter['product_id']]->price,
                        'total_price' => $DBProducts[$filter['product_id']]->price * $filter['qty'],
                        'purchase_history_id' => $purchase_history_id,
                    ]);
                }

            }

        }

        // dd($request->products);

        try {
            if (is_null($request->products) || empty($request->products)) {
                return response()->json(['id' => null, 'message' => 'please select any product !', 'error' => true]);

            }

            DB::beginTransaction();
            $is_Edit = $request->is_edit;
            $products = array_filter($request->products, function ($item) {

                if (! isset($item['product_status'])) {
                    return true;
                }

                return ! in_array($item['product_status'], ['D', 'E']);
            });

            // dd($products);
            if ($request->ajax() && $is_Edit == true && count($products) == 0) {
                return response()->json(['id' => 0, 'message' => 'Order Updated placed !', 'error' => false]);
            }

            $productIds = collect($products)->pluck('product_id');
            $qty_sum = collect($products)->sum('qty');

            $DBProducts = Product::find($productIds)
                ->keyBy('id');
            $sub_total_cost = 0;

            $sale_products = [];
            // dd($qty_sum,$request->products);
            $subtotal = collect($products)->reduce(function ($carry, $item) {
                return $carry + $item['sale_price'] * $item['qty'];
            }, 0);

            $total = $subtotal - $request->discount;

            $request->total = $total;

            foreach ($products as $index => $products_array) {
                if (! isset($DBProducts[$products_array['product_id']])) {
                    continue;
                }
                $temp = [];
                $temp['product_name'] = $DBProducts[$products_array['product_id']]->name;
                $temp['variation'] = $DBProducts[$products_array['product_id']]->variation;
                $temp['unit'] = $DBProducts[$products_array['product_id']]->unit;
                $temp['product_id'] = $DBProducts[$products_array['product_id']]->id;
                $temp['sale_id'] = 0;  // $sales->id
                $temp['qty'] = $products_array['qty'];
                $sub_total_cost += $products_array['qty'] * $DBProducts[$products_array['product_id']]->price;
                if ($DBProducts[$products_array['product_id']]->is_manageable_stock == 1) {
                    $DBProducts[$products_array['product_id']]->decrement('stock', $products_array['qty']);
                }

                $temp['deal_products'] = null;
                if ($DBProducts[$products_array['product_id']]->is_deal == 0) {
                    $temp['deal_products'] = $this->dealProducts($DBProducts[$products_array['product_id']]);
                }

                $temp['cost_price'] = $DBProducts[$products_array['product_id']]->price;
                $temp['sale_price'] = $products_array['sale_price'];
                $sale_products[] = $temp;
            }

            $cost_total = $sub_total_cost - $request->discount;

            [$series, $serial_number, $serial_series] = $this->getInvoiceFields();
            $calcualted_values = [
                'sub_total' => $subtotal,
                'sub_total_cost' => $sub_total_cost - $request->discount,
                'total_qty' => $qty_sum,
                'total' => $total,
                'cost_total' => $sub_total_cost,
                'tax' => $request->tax,
                'shipping' => $request->shipping,
                'serial' => $series,
                'serial_number' => $serial_number,
                'serial_series' => $serial_series,

            ];

            if ($request->tax > 0) {
                $tax = ($subtotal / 100) * $request->tax;

                $calcualted_values['tax_amount'] = $tax;
                $calcualted_values['tax'] = $request->tax;
            } else {
                $calcualted_values['tax_amount'] = 0;
                $calcualted_values['tax'] = 0;
            }

            $calcualted_values['total'] = $calcualted_values['total'] + $calcualted_values['shipping'] + $calcualted_values['tax_amount'];

            $sale_data = array_merge($request->validated(), $calcualted_values);

            $employee = null;
            if (auth()->user()->user_type == 'employee') {
                $sale_data['owner_id'] = auth()->user()->owner_id;
                $sale_data['employee_id'] = auth()->id();
                $employee = auth()->id();
            }

            $order_status = OrderStatus::where('id', 1)->first();
            $order_type = OrderType::where('id', 1)->first();

            $sale_data['order_type_id'] = $order_type->id;
            $sale_data['order_type_name'] = $order_type->name;
            $sale_data['order_status_id'] = $order_status->id;
            $sale_data['order_status_name'] = $order_status->name;

            $sales = Sale::create($sale_data);

            $sale_products = array_map(function ($item) use ($sales, $employee) {
                $item['sale_id'] = $sales->id;
                $item['employee_id'] = $employee;

                return $item;
            }, $sale_products);

            SaleProduct::insert($sale_products);

            // $sales = Sale::with(['Products','Customer'])->find($sales->id);
            // if($sales->Customer->email != null && filter_var($sales->Customer->email, FILTER_VALIDATE_EMAIL))
            //     Mail::to($sales->Customer->email)->send(new SendInvoice($sales,'New Order '));
            DB::commit();

            // $sale = $sales->load('Products', 'Customer');
            if (auth()->user()->send_emails) {
                $cusomer_email = $sales->customer->email ?? null;
                if (! is_null($cusomer_email)) {
                    Mail::to($cusomer_email)->send(new SaleEmail($sales));
                }
            }

            $request->session()->flash('success', 'Sale created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                info($e->getMessage());

                return response()->json(['id' => null, 'message' => 'Order not placed !'.$e->getMessage(), 'error' => true]);
            }
            $request->session()->flash('warning', $e->getMessage());

            return redirect()->back();
        }

        if ($request->ajax()) {
            return response()->json(['id' => $sales->id, 'message' => 'Order placed !', 'error' => false]);
        }

        return redirect()->route('sale.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale): View
    {
        $sales = $sale->load('Products', 'Customer');
        $hide = true;
        $tempalte = auth()->user()->invoice_template;

        return view('pages.'.$tempalte, compact('sales', 'hide'));
    }

    public function employeeshow(Sale $sale)
    {

        if (($sale && $sale->created_at > Carbon::now()->subMinutes(60))
        || (auth()->user()->user_type == 'admin') || (auth()->user()->user_type == 'superadmin')) {
            $sales = $sale->load('Products.Product', 'Customer');
            // dd($sales);
            $hide = true;
            $products = $sales->products;
            $html = view('pages.edit-pos-row', compact('products'))->render();

            return response()->json(['html' => $html, 'sale' => $sales, 'error' => false]);
        } else {
            return response()->json(['html' => '', 'sale' => '', 'error' => true]);
        }

    }

    public function slip(Sale $slip): View
    {
        $sales = $slip->load('Products', 'Customer');
        $hide = true;
        $tempalte = auth()->user()->invoice_template;

        return view('pages.slip', compact('sales', 'hide'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale): View
    {

        $products = Product::where('stock', '>', 0)->get();
        $customers = User::where('owner_id', auth()->id())
            ->where('user_type', 'customer')
            ->get();

        return view('pages.edit-sale', compact('products', 'customers', 'sale'));
    }

    public function updateStock($sale_id)
    {

        try {
            DB::beginTransaction();
            $DBSaleProducts = SaleProduct::where('sale_id', $sale_id)
                ->get()
                ->keyBy('product_id');
            $DBProducts = Product::find($DBSaleProducts->keys())
                ->keyBy('id');

            if ($DBSaleProducts->count() > 0) {
                foreach ($DBSaleProducts as $keyproduct => $orderProduct) {
                    $DBProducts[$keyproduct]->increment('stock', $orderProduct->qty ?? 0);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return true;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, Sale $sale): RedirectResponse
    {

        // Sale Stock  $o 5
        // New Stock  $n 4
        // Taking Difference  $d =  $o - $n
        // positive  increment   $d
        // negative decrement abs($d)

        // dd($request->all());
        $products = array_filter($request->products);
        $productIds = collect($products)->pluck('product_id');
        $qty_sum = collect($products)->sum('qty');
        try {
            DB::beginTransaction();
            $DBProducts = Product::find($productIds)
                ->keyBy('id');
            $sub_total_cost = 0;

            $sale_products = [];
            $subtotal = collect($request->products)->reduce(function ($carry, $item) {
                return $carry + $item['sale_price'] * $item['qty'];
            }, 0);

            $total = $subtotal - $request->discount;

            // $remaining_amount = $subtotal - ($request->paid_amount ?? 0) - ($request->discount ?? 0);

            $request->total = $total;
            $DBSaleProducts = SaleProduct::where('sale_id', $sale->id)
                ->get()
                ->keyBy('product_id');

            foreach ($products as $index => $products_array) {
                if (! isset($DBProducts[$products_array['product_id']])) {
                    continue;
                }
                $temp = [];
                $temp['product_name'] = $DBProducts[$products_array['product_id']]->name;
                $temp['unit'] = $DBProducts[$products_array['product_id']]->unit;
                $temp['product_id'] = $DBProducts[$products_array['product_id']]->id;
                $temp['variation'] = $DBProducts[$products_array['product_id']]->variation;
                $temp['sale_id'] = 0;  // $sales->id
                $temp['qty'] = $products_array['qty'];
                $sub_total_cost += $products_array['qty'] * $DBProducts[$products_array['product_id']]->price;

                if (isset($DBSaleProducts[$products_array['product_id']])) {
                    $difference = $DBSaleProducts[$products_array['product_id']]->qty - $products_array['qty'];
                } else {
                    $difference = -($products_array['qty']);
                }

                if ($difference > 0) {
                    $DBProducts[$products_array['product_id']]->increment('stock', abs($difference));
                } else {
                    $DBProducts[$products_array['product_id']]->decrement('stock', abs($difference));
                }

                $temp['cost_price'] = $DBProducts[$products_array['product_id']]->price;
                $temp['sale_price'] = $products_array['sale_price'];
                $sale_products[] = $temp;
            }
            $calcualted_values = [];
            $cost_total = $sub_total_cost - $request->discount;
            if ($request->tax > 0) {
                $tax = ($subtotal / 100) * $request->tax;

                $calcualted_values['tax_amount'] = $tax;
                $calcualted_values['tax'] = $request->tax;
            } else {
                $calcualted_values['tax_amount'] = 0;
                $calcualted_values['tax'] = 0;
            }

            $calcualted_values['total'] = $total + $request->shipping + $calcualted_values['tax_amount'];

            $remaining_amount = $calcualted_values['total'] - ($request->paid_amount ?? 0);
            $tax_amount = $calcualted_values['tax_amount'];
            $tax = $calcualted_values['tax'];
            $grand_total = $calcualted_values['total'];
            $calcualted_values = [
                'sub_total' => $subtotal,
                'cost_total' => $sub_total_cost,
                'total_qty' => $qty_sum,
                'total' => $grand_total,
                'cost_total' => $cost_total,
                'tax' => $request->tax,
                'tax_amount' => $tax_amount,
                'shipping' => $request->shipping,
                'remaining_amount' => $remaining_amount,

            ];

            $sale_data = array_merge($request->validated(), $calcualted_values);
            unset($sale_data['products']);
            // dd($sale_data);
            $sale_products = array_map(function ($item) use ($sale) {
                $item['sale_id'] = $sale->id;

                return $item;
            }, $sale_products);

            SaleProduct::where('sale_id', $sale->id)->delete();
            SaleProduct::insert($sale_products);
            Sale::where('id', $sale->id)->update($sale_data);
            $sales = Sale::with('Products', 'Customer')->where('id', $sale->id)->first();
            //    if($sales->Customer->email != null && filter_var($sales->Customer->email, FILTER_VALIDATE_EMAIL))
            //         Mail::to($sales->Customer->email)->send(new SendInvoice($sales,'Update Order '));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $request->session()->flash('warning', $e->getMessage());

            return redirect()->back();
        }
        $hide = true;
        $request->session()->flash('success', 'Sale updated successfully.');

        // return redirect('sale/' . $sale->id . '/edit');
        return to_route('sale.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale): RedirectResponse
    {
        $sale->dalete();

        return redirect('sale/'.$sale->id);
    }

    /**
     * Add the specified row from .
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function addNewRow(Request $request)
    {
        $new_row = $request->new_row;
        $totalrecords = $request->totalrecords;
        $products = $request->products;
        $add_products = $request->products;

        // whereNotIn('id',array_values($products))->
        $products = Product::where('stock', '>', 0)->get();
        $html = view('pages.row', compact('new_row', 'totalrecords', 'products', 'add_products'))->render();

        return $html;
    }

    public function addNewRowPos(Request $request)
    {
        $product = Product::where(function ($query) use ($request) {
            $query->where('id', $request->product_id)->where('stock', '>', 0)->where('is_deal', 1)->where('status', 1);
        })->orwhere(function ($query) use ($request) {
            $query->where('id', $request->product_id)
                ->where('is_deal', 0)
                ->whereDate('start_time', '<=', Carbon::now())
                ->whereDate('end_time', '>=', Carbon::now())
                ->where('status', 1);

        })
            ->orwhere(function ($query) use ($request) {
                $query->where('id', $request->product_id)
                    ->orWhere('is_always', 1)
                    ->where('status', 1);

            })
            ->latest()
            ->first();
        // $deals = Deal::where('status', true)
        //     ->whereDate('start_time', '<=', Carbon::now())
        //     ->whereDate('end_time', '>=', Carbon::now())
        //     ->where('id', $request->deal_id)
        //     ->latest()->first();

        $html = view('pages.pos-row', compact('product'))->render();

        return $html;
    }

    public function generatePDF($id)
    {
        $sales = Sale::with(['Products', 'Customer'])
            ->whereId($id)->first();

        // $pdf = Pdf::loadView('pages.print-original', compact('sales'));
        $hide = false;
        $tempalte = auth()->user()->invoice_template;

        // $pdf = Pdf::loadView('pages.' . $tempalte, compact('sales', 'hide'));
        $pdf = Pdf::loadView('pages.slip', compact('sales', 'hide'));

        return $pdf->download('invoice.pdf');
    }

    /**
     * Update Products.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function UpdateProducts(Request $request)
    {
        $new_row = $request->new_row;
        $totalrecords = $request->totalrecords;
        $products = $request->products;
        $add_products = $request->products;
        $products = Product::get();
        $html = view('pages.products_dropdown', compact('new_row', 'totalrecords', 'products', 'add_products'))->render();

        return $html;
    }

    public function getInvoiceFields()
    {
        $months = config('Invoice');
        $month = date('m');
        $year = date('Y');
        // $series  =  $months[$month].$year;
        $series = $months[ltrim($month, '0')].$year;

        $serial_number = (Sale::where('serial', $series)->max('serial_number') ?? 0) + 1;
        // dd($serial_number);
        $serial_series = $series.'-'.$serial_number;

        return [$series, $serial_number, $serial_series];
    }

    public function dealProducts($product)
    {
        $product->load('dealProducts');

        $dealProductsJson = $product->dealProducts->map(function ($dealProduct) {
            return [
                'id' => $dealProduct->id,
                'product_name' => $dealProduct->product_name,
                'price' => $dealProduct->price,
                'discount_price' => $dealProduct->discount_price,
                'quantity' => $dealProduct->quantity,
                'is_swappable' => $dealProduct->is_swappable,
            ];
        })->toJson();

        return $dealProductsJson;
    }
}
