<?php

namespace App\Http\Controllers;

use App\DataTables\DealsDataTable;
use App\Http\Requests\StoreDealRequest;
use App\Http\Requests\UpdateDealRequest;
use App\Models\Deal;
use App\Models\DealProduct;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DealsDataTable $dataTable)
    {

        $currentPage = request()->query('page', 1);

        return $dataTable
            ->with('currentPage', $currentPage)
            ->render('pages.deals.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::get();

        return view('pages.deals.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDealRequest $request): RedirectResponse
    {
        $all_data = $request->validated();
        $deal_products_data = $all_data['productss'];
        unset($all_data['productss']);
        $selected_products = Product::whereIn('id', array_keys($deal_products_data))->get()->pluck(null, 'id');
        // dd($deal_products_data);
        $price = 0;
        $deal_products = [];
        foreach ($deal_products_data as $prodcut) {

            $fProduct = $selected_products[$prodcut['product_id']];

            $price += $fProduct->sale_price * $prodcut['quantity'];
            $deal_products[] = [
                'product_name' => $fProduct->name,
                'price' => $fProduct->price,
                'discount_price' => $fProduct->price,
                'quantity' => $prodcut['quantity'],
                'is_swappable' => isset($prodcut['is_swappable']) ? ($prodcut['is_swappable'] == 'on' ? true : false) : false,
                'deal_id' => 0,
                'owner_id' => $request->owner_id,
            ];

        }
        $all_data['price'] = $price;
        if ($request->hasFile('image')) {
            // et the file with extension
            $image = $request->file('image');

            // Generate a unique file name
            $filename = time().'.'.$image->getClientOriginalExtension();

            // Store the image in the 'public/images' directory
            $path = $image->move('images', $filename, 'public');

            // Optionally, save the image path to the database
            // Example: You can save the path $path in your database
            $all_data['image'] = $path;

        }
        $deal_data = $all_data;

        $deal = Deal::create($deal_data);

        $fdeal_products = array_map(function ($item) use ($deal) {
            $item['deal_id'] = $deal->id;

            return $item;
        }, $deal_products);
        DealProduct::insert($fdeal_products);
        $request->session()->flash('success', 'Deal created successfully.');

        return redirect('deal');

    }

    /**
     * Display the specified resource.
     */
    public function show(Deal $deal): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deal $deal): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDealRequest $request, Deal $deal): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deal $deal): RedirectResponse
    {
        //
    }

    public function selectedProduct(Request $request, Product $product)
    {
        // $product = Product::where('id',$request->id)->first();
        $html = view('pages.deals.product', compact('product'))->render();

        return response()->json(['html' => $html]);
    }
}
