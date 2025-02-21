<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleProductRequest;
use App\Http\Requests\UpdateSaleProductRequest;
use App\Models\SaleProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class SaleProductController extends Controller
{
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
    public function store(StoreSaleProductRequest $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleProduct $saleProduct): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleProduct $saleProduct): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleProductRequest $request, SaleProduct $saleProduct): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleProduct $saleProduct): RedirectResponse
    {
        //
    }
}
