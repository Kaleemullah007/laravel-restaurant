<?php

namespace App\DataTables;

use App\Models\Deal;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DealsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param  QueryBuilder  $query  Results from query() method.
     */
    public function dataTable($query)
    {

        // $qry->where('name', 'like', "%" . request('search')['value'] . "%")
        // ->orWhere('email', 'like', "%" . request('search')['value'] . "%")
        // ->orWhere('created_at', 'like', "%" . request('search')['value'] . "%")
        // ->orWhere('updated_at', 'like', "%" . request('search')['value'] . "%");

        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->setRowId(function ($row) {
                return 'record'.$row->id; // Assign a unique ID to each row
            })
            ->editColumn('id', function ($row) {
                return $row->id;
            })
            ->editColumn('image', function ($row) {
                return image('', $row->image, ['class=" border border-1"', 'style="height: 30px; width: 30px !important"']);
            })
            ->editColumn('deal_name', function ($row) {
                return $row->deal_name.'<br>'.$row->dealProducts->pluck('product_name')->join('<br>');
            })
            ->editColumn('deal_code', function ($row) {
                return $row->deal_code;
            })
            ->editColumn('price', function ($row) {
                return auth()->user()->currency.' '.$row->price;
            })
            ->editColumn('deal_price', function ($row) {
                return auth()->user()->currency.' '.$row->deal_price;
            })

            ->editColumn('action', function ($row) {
                $currentPage = request('page', 1);

                return view('pages.deals.datatable-action', [
                    'row' => $row,
                    'currentPage' => $currentPage,
                ]);
            })

            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value'] != null) {

                    $query->whereHas('dealProducts', function ($qry) {
                        $qry->where('deal_products.product_name', 'like', '%'.request('search')['value'].'%');

                    })
                        ->where('deal_name', 'like', '%'.request('search')['value'].'%')
                        ->orWhere('id', 'like', '%'.request('search')['value'].'%')
                        ->orWhere('created_at', 'like', '%'.request('search')['value'].'%')
                        ->orWhere('price', 'like', '%'.request('search')['value'].'%')
                        ->orWhere('deal_code', 'like', '%'.request('search')['value'].'%')
                        ->orWhere('deal_price', 'like', '%'.request('search')['value'].'%');
                }
            })
            ->setRowClass(function ($row) {

                return ($row->stock <= $row->stock_alert) ? 'bg-alert' : 'bg-transparent';
            })
            ->rawColumns(['image', 'action', 'deal_name']);
    }

    public function query(Deal $model)
    {
        //    dd($currentPage);
        return $model->newQuery()->with(['dealProducts']); // Fetch all with products
    }

    public function html()
    {
        if (request('page') && request('page') > 0) {
            $page = request('page') - 1;
        } else {
            $page = 0;
        }

        return $this->builder()
            ->setTableId('deals-table')
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
                    let table = $('#deals-table').DataTable();
                    let currentPage = table.page() + 1; // Get the current page number
                    
                     $('#deals-table tbody tr').each(function() {
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
                    var table = $('#deals-table').DataTable();
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
                    'sLengthMenu' => __('datatables.show_entries').' <select class="form-control input-sm mx-2" name="deals-table_length" aria-controls="deals-table">
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
                            window.location.href = "/deal/create"; // Example navigation or custom action
                        }',
                    ],
                ]
            );
    }

    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title(__('deals.id'))->searchable(false)->orderable(false),
            Column::make('deal_code')->title(__('deals.deal_code')),
            Column::make('image')->title(__('deals.image'))->orderable(false),
            Column::make('deal_name')->title(__('deals.deal_name')),
            Column::make('price')->title(__('deals.Price')),
            Column::make('deal_price')->title(__('deals.deal_price')),
            Column::computed('action')->title(__('deals.action'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];

    }

    protected function filename(): string
    {
        return 'Deals-'.date('YmdHis');
    }
}
