<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderTypeRequest;
use App\Http\Requests\UpdateOrderTypeRequest;
use App\Models\OrderType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class OrderTypeController extends Controller
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
    public function store(StoreOrderTypeRequest $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderType $orderType): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderType $orderType): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderTypeRequest $request, OrderType $orderType): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderType $orderType): RedirectResponse
    {
        //
    }
}
