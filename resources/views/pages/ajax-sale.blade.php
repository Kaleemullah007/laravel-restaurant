@include('message')
<table class="table border table-striped fs-6 align-middle" style="font-size: 14px !important;">
    <thead style="font-size: 14px !important; font-weight: normal !important">
        <tr>
            <th>{{ __('en.Id') }}</th>
            <th>{{ __('Sale No') }}</th>
            <th>{{ __('en.Customer') }}</th>
            <th>{{ __('en.Product') }}</th>
            <th>{{ __('en.Price') }}</th>
            <th>{{ __('en.Remaining') }}</th>
            <th>{{ __('en.Quantity') }}</th>
            <th>{{ __('en.Due Date') }}</th>
            <th>{{ __('Date and Time') }}</th>
            <th>{{ __('en.Action') }}</th>
        </tr>

    </thead>
    <tbody>
        @if ($sales->count() > 0)


            @php
                if (request('page') > 1) {
                    $counter = (request('page') - 1) * 10 + 1;
                } else {
                    $counter = 1;
                }
            @endphp
            @foreach ($sales as $sale)
                <tr>

                    <td>{{ $counter }}</td>
                    <td> {{ $sale->serial_series }}</td>
                    <td> {{ $sale->Customer->name }}</td>

                    <td>{{ $sale->Products->pluck('product_name')->join(',') }}</td>
                    <td>{{ auth()->user()->currency }} {{ $sale->total }}</td>
                    <td>{{ auth()->user()->currency }} {{ $sale->remaining_amount }}</td>
                    <td>{{ $sale->total_qty }}</td>
                    <td>
                        @if ($sale->due_date)
                            {{ $sale->due_date->toFormattedDateString() }}
                        @endif
                    </td>
                    <td>{{ $sale->created_at->setTimezone('asia/karachi')->format('d-m-Y g:i A') }}</td>
                    <td>
                        <a href="{{ route('sale.show', $sale->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="View"
                            class="box border border-1 border-secondary rounded-pill px-2 py-1 fs-6 link-secondary">
                            <i class="bi bi-eye-fill"></i></a>
                        <a href="{{ route('sale.edit', $sale->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="Edit"
                            class="box border border-1 border-secondary rounded-pill px-2 py-1 fs-6 link-secondary mx-2">
                            <i class="bi bi-pencil"></i></a>
                    </td>
                </tr>
                @php
                    $counter++;
                @endphp
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="10">No record found</td>
            </tr>
        @endif

    </tbody>
</table>
