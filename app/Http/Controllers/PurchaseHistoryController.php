<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseHistoryRequest;
use App\Http\Requests\UpdatePurchaseHistoryRequest;
use App\Models\PurchaseHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class PurchaseHistoryController extends Controller
{
    public function __construct()
    {

        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseHistoryRequest $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseHistory $purchaseHistory): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseHistory $purchaseHistory): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseHistoryRequest $request, PurchaseHistory $purchaseHistory): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseHistory $purchaseHistory): RedirectResponse
    {
        //
    }
}
