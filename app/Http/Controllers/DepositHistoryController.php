<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepositHistoryRequest;
use App\Http\Requests\UpdateDepositHistoryRequest;
use App\Models\Customer;
use App\Models\DepositHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepositHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $DepositHistory = $this->recordsQuery($request)->get();
        $html = view('pages.ajax-deposit', compact('DepositHistory'))->render();

        return response()->json(['html' => $html]);

    }

    public function recordsQuery($request)
    {
        $user_id = $request->user_id;

        $DepositHistory = DepositHistory::query();
        if ($user_id != null) {
            $DepositHistory = $DepositHistory->where('user_id', $user_id);
        }

        return $DepositHistory;
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
    public function store(StoreDepositHistoryRequest $request): RedirectResponse
    {
        $expenses = DepositHistory::create($request->validated());
        $request->session()->flash('success', 'Deposit added successfully.');

        return redirect()->route('customer.show', ['customer' => $request->user_id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DepositHistory $depositHistory): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepositHistory $deposit)
    {

        $customers = Customer::whereIn('user_type', ['vendor', 'customer'])->get();

        return view('pages.edit-deposit', compact('deposit', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepositHistoryRequest $request, DepositHistory $deposit): RedirectResponse
    {
        DepositHistory::where('id', $deposit->id)->update($request->validated());
        $request->session()->flash('success', 'Deposit Amount updated successfully.');

        return redirect()->route('deposit.edit', $deposit->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepositHistory $depositHistory): RedirectResponse
    {
        //
    }
}
