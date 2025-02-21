<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderStatusRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\OrderStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class OrderStatusController extends Controller
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
    public function store(StoreOrderStatusRequest $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderStatus $orderStatus): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderStatus $orderStatus): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderStatusRequest $request, OrderStatus $orderStatus): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderStatus $orderStatus): RedirectResponse
    {
        //
    }
}
