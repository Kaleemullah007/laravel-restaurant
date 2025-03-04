<?php

namespace App\DataTables;

use App\Models\Product;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
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
            ->editColumn('is_Deal', function ($row) {
                $is_deal = 'Product';
                $class = 'bg-warning text-dark';
                if ($row->is_deal == 0) {
                    $is_deal = 'Deal';
                    $class = 'bg-info text-dark';
                }

                return '<span class="badge '.$class.'">'.$is_deal.'</span>';
            })

            // ->editColumn('name', function ($row) {
            //     return $row->name;
            // })
            ->editColumn('name', function ($row) {
                return $row->name.' '.$row->variation;
            })

            ->editColumn('stock_alert', function ($row) {
                return $row->stock_alert;
            })
            ->editColumn('stock', function ($row) {
                return $row->stock.' '.$row->unit;
            })
            ->editColumn('product_code', function ($row) {
                return $row->product_code;
            })

            ->editColumn('price', function ($row) {
                return auth()->user()->currency.' '.$row->price;
            })
            ->editColumn('sale_price', function ($row) {
                return auth()->user()->currency.' '.$row->sale_price;
            })

            ->editColumn('action', function ($row) {
                $currentPage = request('page', 1);

                return view('products.datatable-action', [
                    'row' => $row,
                    'currentPage' => $currentPage,
                ]);
            })

            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value'] != null) {

                    $query->Where(function ($qry) {
                        $qry->where('name', 'like', '%'.request('search')['value'].'%')
                            ->orWhere('id', 'like', '%'.request('search')['value'].'%')
                            ->orWhere('created_at', 'like', '%'.request('search')['value'].'%')
                            ->orWhere('stock', 'like', '%'.request('search')['value'].'%')
                            ->orWhere('stock_alert', 'like', '%'.request('search')['value'].'%')
                            ->orWhere('price', 'like', '%'.request('search')['value'].'%')
                            ->orWhere('product_code', 'like', '%'.request('search')['value'].'%')
                            ->orWhere('sale_price', 'like', '%'.request('search')['value'].'%');
                    });
                }
            })
            ->setRowClass(function ($row) {

                return ($row->stock <= $row->stock_alert) ? 'bg-alert' : 'bg-transparent';
            })
            ->rawColumns(['image', 'action', 'is_Deal']);
    }

    public function query(Product $model)
    {
        //    dd($currentPage);
        return $model->newQuery(); // Fetch all purchases
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
                            window.location.href = "/product/create"; // Example navigation or custom action
                        }',
                    ],
                ]
            );
    }
    // public function html()
    // {
    //     if (request('page') && request('page') > 0) {
    //         $page = request('page') - 1;
    //     } else {
    //         $page = 0;
    //     }
    //     return $this->builder()
    //         ->setTableId('records-table')
    //         ->columns($this->getColumns())
    //         ->minifiedAjax()
    //         ->dom('Bfrltip')
    //         // lBfrtip , Bfrltip, Bfrtip,
    //         // ->dom('<"top"i>rt<"bottom"lp><"clear">')
    //         ->orderBy(0)
    //         ->parameters([
    //             'pageLength' => 10, // Default number of records per page
    //             'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']], // Options for the per page dropdown
    //             'drawCallback' => "function(settings) {
    //                 let table = $('#records-table').DataTable();
    //                 let currentPage = table.page() + 1; // Get the current page number

    //                  $('#records-table tbody tr').each(function() {
    //                 let row = $(this);
    //                 row.find('a').each(function() {
    //                     let link = $(this);
    //                     let href = new URL(link.attr('href'), window.location.origin);
    //                     href.searchParams.set('page', currentPage);
    //                     link.attr('href', href.toString());
    //                 });
    //             });

    //                 history.replaceState(null, '', '?page=' + currentPage);
    //             }",
    //             'initComplete' => "function(settings, json) {
    //                 var table = $('#records-table').DataTable();
    //                 table.page(" . $page . ").draw(false); // Set to the second page (index 1)
    //             }",
    //             'processing' => true, // Enable the built-in processing indicator
    //             'serverSide' => true,
    //             'ajax' => [
    //                 'url' => route('purchase.index'),
    //                 'type' => 'GET',
    //                 'beforeSend' => "function() {
    //                 $('#loader').show(); // Show loader
    //             }",
    //                 'complete' => "function() {
    //                 $('#loader').hide(); // Hide loader
    //             }",
    //             ]

    //         ])
    //         ->buttons(
    //             // ['excel', 'csv', 'pdf', 'print','reload']
    //             Button::make('excel')->addClass('btn btn-sm btn-primary'),
    //             Button::make('csv')->addClass('btn btn-sm btn-secondary'),
    //             Button::make('pdf')->addClass('btn btn-sm btn-success'),
    //             Button::make('print')->addClass('btn btn-sm btn-danger'),
    //             //     Button::make('print')->text('Print All Records')->addClass('btn btn-info')->action("
    //             //     function (e, dt, button, config) {
    //             //         dt.page.len(-1).draw(); // Set to 'All' records before printing
    //             //         $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
    //             //         dt.page.len(10).draw(); // Reset to default page length
    //             //     }
    //             // ")
    //             // Button::make('reload')->addClass('btn btn-secondary'),
    //         );
    // }
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title(__('products.id'))->searchable(false)->orderable(false),
            Column::make('product_code')->title(__('products.product_code')),
            Column::make('image')->title(__('products.image'))->orderable(false),
            Column::make('is_Deal')->title(__('products.is_Deal')),
            Column::make('name')->title(__('products.name')),
            Column::make('stock')->title(__('products.stock')),
            Column::make('stock_alert')->title(__('products.stock_alert')),
            Column::make('price')->title(__('products.Cost_Price')),
            Column::make('sale_price')->title(__('products.sale_price')),
            Column::computed('action')->title(__('products.action'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Products'.date('YmdHis');
    }
}
