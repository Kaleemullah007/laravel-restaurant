<?php

namespace App\DataTables;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    public function dataTable($query)
    {

        // $qry->where('name', 'like', "%" . request('search')['value'] . "%")
        // ->orWhere('email', 'like', "%" . request('search')['value'] . "%")
        // ->orWhere('created_at', 'like', "%" . request('search')['value'] . "%")
        // ->orWhere('updated_at', 'like', "%" . request('search')['value'] . "%");

        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('name', function ($row) {
                return $row->name;

            })
            ->editColumn('difference', function ($row) {

                return view('customers.customer-stat', [
                    'row' => $row,
                ]);

            })
            ->editColumn('phone', function ($row) {
                return $row->phone;
            })
            ->editColumn('email', function ($row) {
                return $row->email;
            })
        //   ->editColumn('email', function ($row) {
        //     return $row->$amount ;
        //   })
            ->editColumn('id', function ($row) {
                return $row->id;
            })
            ->editColumn('user_type', function ($row) {
                return $row->user_type;
            })
        //   ->editColumn('action', function ($row) {
        //     return 'action file';

        //   })
            ->editColumn('action', function ($row) {
                $currentPage = request('page', 1);

                return view('customers.datatable-action', [
                    'row' => $row,
                    'currentPage' => $currentPage,
                ]);
            })
            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value'] != null) {
                    $query->where(function ($qry) {
                        $qry->where('name', 'like', '%'.request('search')['value'].'%')
            // ->orWhere('email', 'like', "%" . request('search')['value'] . "%")
                            ->orWhere('created_at', 'like', '%'.request('search')['value'].'%')
                            ->orWhere('updated_at', 'like', '%'.request('search')['value'].'%')
                            ->orWhere('email', 'like', '%'.request('search')['value'].'%')
                            ->orWhere('phone', 'like', '%'.request('search')['value'].'%')
                            ->orWhere('user_type', 'like', '%'.request('search')['value'].'%');

                    });
                }
            })
            ->setRowClass(function ($row) {
                $amount = $row->customer_sale_sum_remaining_amount - $row->desposit_sum_sum_amount;

                return ($amount > 0) ? 'bg-alert' : 'bg-transparent';
            });
    }

    public function query(Customer $model)
    {
        //    dd($currentPage);
        return $model->newQuery()->withSum('customerSale', 'discount')
            ->withSum('customerSale', 'total')
            ->withSum('customerSale', 'paid_amount')
            ->withSum('customerSale', 'remaining_amount')
            ->withSum('DespositSum', 'amount')
            ->withSum('vendorProdudctPurchases', 'remaining_amount')
        // ->addSelect(DB::raw('(customer_sale_sum_remaining_amount - desposit_sum_sum_amount) AA DFF'))
            ->selectRaw(
                '(COALESCE((SELECT SUM(sales.remaining_amount) FROM sales WHERE sales.user_id = users.id), 0) - 
            COALESCE((SELECT SUM(deposit_histories.amount) FROM deposit_histories WHERE deposit_histories.user_id = users.id), 0)) AS difference'
            );
        // Fetch all users
    }

    public function html()
    {
        if (request('page') && request('page') > 0) {
            $page = request('page') - 1;
        } else {
            $page = 0;
        }

        return $this->builder()
            ->setTableId('users-table')
            ->addTableClass('table-striped table-bordered')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrltip')
            // lBfrtip , Bfrltip, Bfrtip,
            // ->dom('<"top"i>rt<"bottom"lp><"clear">')
            ->orderBy(0)
            ->parameters([
                'pageLength' => 10, // Default number of records per page
                'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']], // Options for the per page dropdown
                'drawCallback' => "function(settings) {
                    let table = $('#users-table').DataTable();
                    let currentPage = table.page() + 1; // Get the current page number
                    
                     $('#users-table tbody tr').each(function() {
                    let row = $(this);
                    row.find('a').each(function() {
                        let link = $(this);
                        let href = new URL(link.attr('href'), window.location.origin);
                        href.searchParams.set('page', currentPage);
                        link.attr('href', href.toString());
                    });
                });
                
                    history.replaceState(null, '', '?page=' + currentPage);
                }",
                'initComplete' => "function(settings, json) {
                    var table = $('#users-table').DataTable();
                    table.page(".$page.').draw(false); // Set to the second page (index 1)
                }',
                'processing' => true, // Enable the built-in processing indicator
                'serverSide' => true,
                'ajax' => [
                    'url' => route('customer.index'),
                    'type' => 'GET',
                    'beforeSend' => "function() {
                    $('#loader1').show(); // Show loader
                }",
                    'complete' => "function() {
                    $('#loader1').hide(); // Hide loader
                }", ],
                'language' => [
                    'paginate' => [
                        'previous' => __('datatables.previous'),   // Previous button label
                        'next' => __('datatables.next'),         // Next button label
                    ],
                    'search' => __('datatables.search'),  // Custom search text
                    'searchPlaceholder' => __('datatables.search_placeholder'),  // Optionally, a placeholder translation
                    'sLengthMenu' => __('datatables.show_entries').' <select class="form-control input-sm mx-2" name="users-table_length" aria-controls="users-table">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="-1">'.__('datatables.All').'</option>
                </select> '.__('datatables.entries'), // Customize "Show entries" text

                    'sInfo' => __('datatables.showing_info'), // Customize showing info text
                    'sInfoEmpty' => __('datatables.no_entries'), // Customize when no entries
                    'sZeroRecords' => __('datatables.no_records_found'), // Customize when no records found
                ],

            ])
            ->buttons(
                [
                    Button::make('excel')->addClass('btn btn-sm btn-excel'),
                    Button::make('csv')->addClass('btn btn-sm btn-csv'),
                    Button::make('pdf')->addClass('btn btn-sm btn-pdf'),
                    Button::make('print')->text(__('datatables.print'))->addClass('btn btn-sm btn-print'),
                    [
                        'text' => '<i class="bi bi-plus-circle me-2"></i> '.__('datatables.Create'), // Custom button text
                        'className' => 'btn btn-sm btn-primary', // Custom styling classes
                        'action' => 'function (e, dt, node, config) {
                            // You can add a custom JavaScript function here
                            window.location.href = "/customer/create"; // Example navigation or custom action
                        }',
                    ],
                ]

            );
    }

    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title(__('users.id'))->searchable(false)->orderable(false),
            Column::make('name')->title(__('users.name')),
            Column::make('user_type')->title(__('users.user_type')),
            // Column::make('amount')->title(__('users.balance_due')),

            Column::make('phone')->title(__('users.phone')),
            Column::make('difference')->title(__('users.balance_due')),

            Column::make('email')->title(__('users.email')),
            Column::computed('action')->title(__('users.action'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'users'.date('YmdHis');
    }
}
