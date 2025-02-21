<?php

namespace App\Http\Controllers;

use App\DataTables\ExpenseDataTable;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function __construct()
    {

        $this->middleware(['auth', 'verified']);
    }

    public function index(ExpenseDataTable $dataTable)
    {
        $currentPage = request()->query('page', 1);

        return $dataTable
            ->with('currentPage', $currentPage)
            ->render('expenses.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index1(Request $request)
    {
        $expenses = $this->recordsQuery($request)->paginate(config('services.per_page', 10));
        if ($expenses->lastPage() >= request('page')) {
            return view('pages.expense', compact('expenses'));
        }

        return to_route('expense.index', ['page' => $expenses->lastPage()]);
    }

    public function recordsQuery($request)
    {
        // withoutGlobalScopes()->
        $expenses = Expense::query();
        $search = $request->search;
        $dates = $request->daterange;

        if ($dates != null) {
            [$start_date, $end_date] = explode('-', $dates);
            $start_date = changeDateFormat($start_date, 'Y-m-d');
            $end_date = changeDateFormat($end_date, 'Y-m-d');
            $expenses = $expenses->whereDate('date', '>=', $start_date)
                ->whereDate('date', '<=', $end_date);
        }
        if ($search != null) {
            $expenses = $expenses->where('name', 'like', '%'.$search.'%');
        }

        return $expenses;
    }

    public function getExpenses(Request $request)
    {

        $expenses = $this->recordsQuery($request)->get();
        $expenses_html = view('pages.ajax-expense', compact('expenses'))->render();
        $pagination_html = view('pages.pagination', compact('expenses'))->render();

        return response()->json(['html' => $expenses_html, 'phtml' => $pagination_html]);
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

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {

        // return view('expense');
        return view('pages.create-expense');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request): RedirectResponse
    {
        $expenses = Expense::create($request->validated());
        $request->session()->flash('success', 'Expense created successfully.');

        // return redirect()->route('expense.create');
        return to_route('expense.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense): View
    {
        return redirect('edit-expense', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense): View
    {
        // return redirect('edit-expense',compact('expense'));
        return view('pages.edit-expense', compact('expense'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense): RedirectResponse
    {

        Expense::where('id', $expense->id)->update($request->validated());
        $request->session()->flash('success', 'Expense updated successfully.');

        // return redirect('expense/'.$expense->id.'/edit');
        return to_route('expense.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense): RedirectResponse
    {
        $expense->dalete();

        return redirect('expense/'.$expense->id);
    }
}
