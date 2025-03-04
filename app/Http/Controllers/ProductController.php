<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Service\DealService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected $dealService;

    public function __construct(DealService $dealService)
    {

        $this->middleware(['auth', 'verified']);
        $this->dealService = $dealService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        $currentPage = request()->query('page', 1);

        return $dataTable
            ->with('currentPage', $currentPage)
            ->render('products.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index1()
    {
        $products = $this->recordsQuery();

        if ($products->lastPage() >= request('page')) {
            return view('pages.product', compact('products'));
        }

        return to_route('product.index', ['page' => $products->lastPage()]);

    }

    public function recordsQuery($search = null)
    {
        // withoutGlobalScopes()->
        $products = new Product;

        if ($search != null) {

            $products = $products->where('name', 'like', '%'.$search.'%')->orWhere('product_code', 'like', '%'.$search.'%');
        }
        $products = $products->latest()->paginate(config('services.per_page', 10));

        return $products;
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

    // Get Products

    public function getProducts(Request $request)
    {

        $products = $this->recordsQuery($request->search);
        $products_html = view('pages.ajax-product', compact('products'))->render();
        $pagination_html = view('pages.pagination', compact('products'))->render();

        return response()->json(['html' => $products_html, 'phtml' => $pagination_html]);
    }

    public function getProductsForPos(Request $request)
    {

        $products = $this->recordsQuery($request->search);
        $products_html = view('pages.ajax-pos-products', compact('products'))->render();

        return response()->json(['html' => $products_html, 'products_count' => $products->count(), 'product_id' => $products[0]->id ?? null]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $products = Product::get();

        return view('pages.create-product', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {

        // dd(mime_content_type($request->file('image')->getPathName()));
        if(!$request->is_product_value){
            $this->dealService->createDeal($request);
            $product = 'Deal';
        }
        else{
            $id = request('redirectid');
            $product = 'Product';
            $data = $request->validated();
    
            if ($request->hasFile('image')) {
                // et the file with extension
                $image = $request->file('image');
    
                // Generate a unique file name
                $filename = time().'.'.$image->getClientOriginalExtension();
    
                // Store the image in the 'public/images' directory
                $path = $image->move('images', $filename, 'public');
    
                // Optionally, save the image path to the database
                // Example: You can save the path $path in your database
                $data['image'] = $path;
    
            }
    
            $products = Product::create($data);
            $request->session()->flash('success', 'Product created successfully.');
            if ($id) {
                return redirect('product?id='.$id);
            }
    
        }
        $request->session()->flash('success', $product.' created successfully.');
        return redirect('product');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('edit-product', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {

        $product->load('dealProducts');
       
        // dd($product);
        $products = Product::where('id', '!=', $product->id)->latest()->get();
        return view('pages.edit-product', compact('product','products'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {

        $this->authorize('update', $product);
        $tproduct = 'Product';
        $data = $request->validated();
        if(!$request->is_product_value){
            $this->dealService->updateDeal($request,$product);
            $tproduct = 'Deal';
           
        }
        else{
        if ($request->hasFile('image')) {
            // et the file with extension
            $image = $request->file('image');

            // Generate a unique file name
            $filename = time().'.'.$image->getClientOriginalExtension();

            // Store the image in the 'public/images' directory
            $path = $image->move('images', $filename, 'public');

            // Optionally, save the image path to the database
            // Example: You can save the path $path in your database
            $data['image'] = $path;
        } else {
            unset($data['image']);
        }
        $products = Product::where('id', $product->id)->update($data);
       
    }
        $request->session()->flash('success', "$tproduct updated successfully.");
        //    return redirect('product/'.$product->id.'/edit');
        return to_route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        $error = false;
        try {
            if ($product->delete()) {
                $error = true;
            }

            return response()->json(['error' => $error]);
        } catch (Exception $e) {
            return response()->json(['error' => false, 'message' => 'You can not delete this product due having some sales']);
        }

    }

    public function getPrice(Product $product)
    {

        $color = 'red';
        if ($product->stock > $product->stock_alert) {
            $color = 'green';
        }

        return response()->json(['sale_price' => $product->sale_price, 'stock' => $product->stock, 'color' => $color], 200);
    }
}
