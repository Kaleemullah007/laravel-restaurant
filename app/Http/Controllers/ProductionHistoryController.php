<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductionHistoryRequest;
use App\Http\Requests\UpdateProductionHistoryRequest;
use App\Models\Product;
use App\Models\ProductionHistory;
use App\Models\Purchase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductionHistoryController extends Controller
{
    public function __construct()
    {

        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $productions = $this->recordsQuery($request)->paginate(config('services.per_page', 10));
        if ($productions->lastPage() >= request('page')) {
            return view('pages.production', compact('productions'));
        }

        return to_route('production.index', ['page' => $productions->lastPage()]);
    }

    public function getProduction(Request $request)
    {

        $productions = $this->recordsQuery($request)
            ->get();
        $productions_html = view('pages.ajax-production', compact('productions'))->render();
        $pagination_html = view('pages.pagination', compact('productions'))->render();

        return response()->json(['html' => $productions_html, 'phtml' => $pagination_html]);
    }

    public function recordsQuery($request)
    {

        $productions = ProductionHistory::query()
            ->with(['Product', 'RawMaterial']);

        $search = $request->search;
        $dates = $request->daterange;

        if ($dates != null) {
            [$start_date, $end_date] = explode('-', $dates);
            $start_date = changeDateFormat($start_date, 'Y-m-d');
            $end_date = changeDateFormat($end_date, 'Y-m-d');
            $productions = $productions->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date);
        }
        if ($search != null) {

            $productions = $productions
                ->whereHas('RawMaterial', function ($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%');
                })->
            orWhereHas('Product', function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%');
            });
        }

        return $productions;

    }

    public function CSV(Request $request)
    {

        $sales = $this->recordsQuery($request->daterange);
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

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // dd(auth()->user()->id);
        $products = Product::get();
        $raws = Purchase::get();

        return view('pages.create-production', compact('raws', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductionHistoryRequest $request): RedirectResponse
    {
        $perchase = Purchase::find($request->purchase_id);
        $total_purchase_stock = $request->qty + $request->wastage_qty;
        if ($perchase->qty < $total_purchase_stock) {
            $request->session()->flash('warning', 'Production can not be greater than Purchased Stock');

            return redirect()->to(route('production.create'))->withInput($request->input());
        }

        $product = Product::find($request->product_id);
        if ($product == null) {
            throw new \ErrorException('Product not found');
        }

        $product->increment('stock', abs($request->qty));

        $perchase->decrement('qty', $total_purchase_stock);
        // dd($request->validated());
        ProductionHistory::create($request->validated());
        $request->session()->flash('success', 'Production created successfully.');

        return redirect('production');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductionHistory $production): View
    {
        return view('edit-production', compact('production'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductionHistory $production): View
    {
        // dd(auth()->user()->id);
        $products = Product::get();
        $raws = Purchase::get();

        // dd($raws);
        return view('pages.edit-production', compact('products', 'raws', 'production'));

    }

    /**
     * Checking Purchase stock before update Production.
     */
    public function checkPurchaseBeforeUpdateProduction($purchase, $request, $production)
    {
        $flag = true;
        $difference_wastage = $request->wastage_qty - $production->wastage_qty;
        $difference = $request->qty - $production->qty;

        if ($difference < 0) {
            $product_q = $difference;
        } else {
            $product_q = $difference;
        }

        if ($difference_wastage < 0) {
            $product_w = $difference_wastage;

        } else {
            $product_w = $difference_wastage;

        }

        $total_qty = $product_q + $product_w;
        if ($purchase->qty < $total_qty) {
            $flag = false;
        }

        return $flag;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductionHistoryRequest $request, ProductionHistory $production): RedirectResponse
    {

        $purchase = Purchase::find($request->purchase_id);

        if ($this->checkPurchaseBeforeUpdateProduction($purchase, $request, $production) == false) {
            $request->session()->flash('warning', 'Production can not be greater than Purchased Stock');

            return redirect()->back();

        }

        $product = Product::find($request->product_id);
        if ($product == null) {
            throw new \ErrorException('Product not found');
        }

        $difference = $production->qty - $request->qty;

        $difference_wastage = $production->wastage_qty - $request->wastage_qty;

        if ($difference <= 0) {
            $product->increment('stock', abs($difference));
            $purchase->decrement('qty', abs($difference));

        } else {
            $product->decrement('stock', abs($difference));
            $purchase->increment('qty', abs($difference));
        }

        $purchase->refresh();
        if ($difference_wastage <= 0) {
            $purchase->decrement('qty', abs($difference_wastage));
        } else {
            $purchase->increment('qty', abs($difference_wastage));
        }

        $products = ProductionHistory::where('id', $production->id)->update($request->validated());
        $request->session()->flash('success', 'Production updated successfully.');

        return redirect('production/'.$production->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductionHistory $production): RedirectResponse
    {
        $production->dalete();

        return redirect('production/'.$production->id);
    }
}
