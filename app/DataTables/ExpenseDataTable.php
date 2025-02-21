<?php

namespace App\DataTables;

use App\Models\Expense;
use Carbon\Carbon;
use Exception;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ExpenseDataTable extends DataTable
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
            ->editColumn('amount', function ($row) {
                return auth()->user()->currency.' '.$row->amount;
            })
            ->editColumn('date', function ($row) {
                return Carbon::parse($row->date)->toFormattedDateString();
            })
            ->editColumn('id', function ($row) {
                return $row->id;
            })
            //   ->editColumn('action', function ($row) {
            //     return 'action file';

            //   })
            ->editColumn('action', function ($row) {
                $currentPage = request('page', 1);

                return view('expenses.datatable-action', [
                    'row' => $row,
                    'currentPage' => $currentPage,
                ]);
            })

            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value'] != null) {
                    $query->where(function ($qry) {
                        $qry->where('name', 'like', '%'.request('search')['value'].'%')
                            ->orWhere('amount', 'like', '%'.request('search')['value'].'%')
                            ->orWhere('id', 'like', '%'.request('search')['value'].'%');

                        $searchDate = request('search')['value'];
                        try {
                            $formattedDate = Carbon::parse($searchDate)->toDateString(); // Converts to '2023-03-25'

                        } catch (Exception $e) {
                            $formattedDate = null;
                        }
                        if (! is_null($formattedDate)) {
                            $qry->orWhere('date', 'like', '%'.$formattedDate.'%');
                        }

                    });
                }
            });
    }

    public function query(Expense $model)
    {
        //    dd($currentPage);
        return $model->newQuery(); // Fetch all users
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
                            window.location.href = "/expense/create"; // Example navigation or custom action
                        }',
                    ],
                ]
            );
    }

    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title(__('expenses.id'))->searchable(false)->orderable(false),
            // Column::make('id')->title(__('expenses.id')),
            Column::make('name')->title(__('expenses.name')),
            Column::make('amount')->title(__('expenses.amount')),
            Column::make('date')->title(__('expenses.date')),
            Column::computed('action')->title(__('expenses.action'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];

    }

    protected function filename(): string
    {
        return 'expense'.date('YmdHis');
    }
}
