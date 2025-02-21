<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\DepositHistory;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct()
    {

        $this->middleware(['auth', 'verified']);
    }

    public function index(UsersDataTable $dataTable)
    {

        // $customers = Customer::query()
        // //withSum(
        // // ['customerSale'],'sale_price')
        // ->withSum('vendorProdudctPurchases','remaining_amount')
        // ->get();

        // dd($customers);

        $currentPage = request()->query('page', 1);

        // $customer_id = request()->query('customer_id',null);
        return $dataTable
            ->with('currentPage', $currentPage)
            ->render('customers.index');
    }

    public function recordsQuery($request)
    {
        $search = $request->search;

        $customers = Customer::query()->
                            // withSum(
                            // ['customerSale'],'sale_price')
                             withSum('customerSale', 'discount')
                                 ->withSum('customerSale', 'total')
                                 ->withSum('customerSale', 'paid_amount')
                                 ->withSum('customerSale', 'remaining_amount')
                                 ->withSum('DespositSum', 'amount')
                                 ->latest();
        // ->where('user_type','customer');
        if ($search != null) {
            $customers = $customers->where('name', 'like', '%'.$search.'%');
        }

        return $customers;
    }

    /**
     * Display a listing of the resource.
     */
    public function index1(Request $request)
    {
        $customers = $this->recordsQuery($request)
            ->orderByRaw('(customer_sale_sum_remaining_amount - desposit_sum_sum_amount) DESC')
            ->paginate(config('services.per_page', 10));

        if ($customers->lastPage() >= request('page')) {
            return view('pages.customer', compact('customers'));
        }

        return to_route('customer.index', ['page' => $customers->lastPage()]);

    }

    public function getCustomers(Request $request)
    {

        $customers = $this->recordsQuery($request)->get();
        $customer_html = view('pages.ajax-customer', compact('customers'))->render();
        $pagination_html = view('pages.pagination', compact('customers'))->render();

        return response()->json(['html' => $customer_html, 'phtml' => $pagination_html]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {

        return view('pages.create-customer');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {

        // dd($request->all());
        $user = Customer::create($request->only([
            'name',
            'first_name',
            'last_name',
            'email',
            'phone',
            'user_type',
            'owner_id',
            'password',
            'is_tester',
            'change_price',
            'currency',
            'email_verified_at',
        ]));

        if ($user->user_type == 'admin') {
            $walkInData = [
                'name' => 'Walk-in Customer',
                'first_name' => 'Walk-in',
                'last_name' => 'Customer',
                'email' => 'customer@rktech.com', // If email isn't available, set it to null
                'phone' => '000000000',
                'user_type' => 'customer', // Assuming a specific type for walk-in customers
                'owner_id' => $user->id, // Assuming no owner ID for walk-ins
                'password' => Hash::make('password'), // No password for walk-ins
                'is_tester' => false, // Assuming walk-ins are not testers
                'change_price' => false, // Default value if not applicable
                'currency' => $user->currency, // Default currency, change as needed
            ];

            $user = Customer::create($walkInData);
        }
        if ($request->ajax()) {
            return response()->json(['message' => 'Successfully created', 'error' => true, 'data' => $user]);
        }

        $request->session()->flash('success', 'User created successfully.');

        return redirect('customer');

    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer): View
    {
        $DepositHistory = DepositHistory::where('user_id', $customer->id)->get();
        $customers = Customer::whereIn('user_type', ['customer', 'vendor'])->get();

        return view('pages.create-deposit', compact('customer', 'customers', 'DepositHistory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer): View
    {
        return view('pages.edit-customer', compact('customer'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer): RedirectResponse
    {
        $data = $request->validated();

        $validated = collect($data)->except(['page'])->toArray();
        // dd($validated);
        Customer::where('id', $customer->id)->update($validated);
        $request->session()->flash('success', 'User updated successfully.');

        return redirect('customer?page='.$request->page);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        //
    }

    // Customer Remaining or surplus

    public function CalculateAmount($request)
    {
        return DepositHistory::query()
            ->join('users', 'deposit_histories.user_id', '=', 'users.id')
            ->where('deposit_histories.user_id', $request->id);
    }

    public function customerAmount(Request $request, Customer $customer)
    {
        if (! $request->ajax()) {
            return response()->json(['price' => 0, 'message' => '', 'addClass' => '']);
        }
        $amount = $this->CalculateAmount($customer);
        // dd($amount,$customer);
        $amount = $amount->where('user_type', 'customer')->sum('amount');

        $remaining_amount = Sale::query()->where('user_id', $customer->id);
        $remaining_amount = $remaining_amount
            ->sum('remaining_amount');
        $remaining_amount = $remaining_amount - $amount;
        // dd($remaining_amount , $amount);
        $message = '';
        $addClass = 'text-danger';
        if ($remaining_amount < 0) {
            $message = 'minus means surplus';
            $addClass = 'text-success';
        }

        return response()->json(['price' => $remaining_amount, 'message' => $message, 'currency' => auth()->user()->currency, 'addClass' => $addClass]);
    }

    // Customer Remaining or surplus
    public function VendorAmount(Request $request, Customer $customer)
    {

        if (! $request->ajax()) {
            return response()->json(['price' => 0, 'message' => '', 'addClass' => '']);
        }
        // purchases_history
        $amount = $this->CalculateAmount($customer);
        $vendor_remaining = $amount->where('user_type', 'vendor')->sum('amount');
        $purchases_history = Purchase::query()->where('user_id', $customer->id);
        $remain_payable = $purchases_history->sum(DB::raw('remaining_amount'));
        $vendor_remainng = $remain_payable - $vendor_remaining;
        $message = '';
        $addClass = 'text-danger';
        if ($vendor_remainng < 0) {
            $message = 'minus means Receivable ';
            $addClass = 'text-success';
        }

        return response()->json(['price' => $vendor_remainng, 'currency' => auth()->user()->currency, 'message' => $message, 'addClass' => $addClass]);
    }
}
