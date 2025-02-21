<?php

namespace App\Http\Controllers;

use App\DataTables\PurchaseReturnDataTable;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseHistory;
use App\Models\PurchaseReturn;
use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{
    public function __construct()
    {

        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PurchaseReturnDataTable $dataTable)
    {
        $currentPage = request()->query('page', 1);

        // dd('ss');
        return $dataTable
            ->with('currentPage', $currentPage)
            ->render('purchasereturn.index');
    }

    public function edit(PurchaseReturn $purchaseReturn)
    {

        $vendors = Purchase::with('vendor')->where('product_id', $purchaseReturn->product_id)
            ->distinct()
            ->groupBy('product_id')
            ->get();

        return view('purchasereturn.edit-purchase-return', compact('purchaseReturn', 'vendors'));

    }

    public function update(Request $request, PurchaseReturn $purchaseReturn)
    {

        if ($purchaseReturn->is_process == false) {

            $originalPurchase = PurchaseHistory::where('purchase_history_id', $request->user_id)->first();

            if ($originalPurchase) {
                // Clone the original purchase and update the quantity
                $clonedPurchase = $originalPurchase->replicate(); // Replicate the original record
                $clonedPurchase->qty = $request->qty;  // Update the quantity field
                $clonedPurchase->is_returnable = true;
                $clonedPurchase->save(); // Save the cloned record

            }

            $product = Product::find($request->product_id);
            $purchase = Purchase::find($request->user_id);
            $product->decrement('stock', $request->qty);
            $purchase->decrement('qty', $request->qty);
            $purchaseReturn->is_process = true;
            $purchaseReturn->save();
            $request->session()->flash('success', 'Updated Succesfully');

        } else {
            $request->session()->flash('error', 'It can be updated One time');

        }

        return to_route('purchase-return.index', ['page' => request('page', 1)]);

    }
}
