<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Models\Customer;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class VendorController extends Controller
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
    public function store(StoreVendorRequest $request)
    {
        $user = Customer::create($request->only([
            'name',
            'email',
            'phone',
            'user_type',
            'owner_id',
            'password',
        ]));

        return response()->json(['message' => 'Successfully created', 'error' => true, 'data' => $user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendorRequest $request, Vendor $vendor): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor): RedirectResponse
    {
        //
    }
}
