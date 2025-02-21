@include('message')

<table class="table border table-striped align-middle">
    <thead>
        <tr>
            <th>{{ __('en.Id') }}</th>
            <th>{{ __('en.Vendor') }}</th>
            <th>{{ __('en.Name') }}</th>
            <th>{{ __('en.Quantity') }}</th>
            <th>Cost Price</th>
            <th>{{ __('en.Selling price') }}</th>
               <th>{{ __('Date and Time') }}</th>

            <th>{{ __('en.Action') }}</th>
        </tr>
    </thead>
    <tbody>
        @if ($purchases->count() > 0)

        @php
         if(request('page')>1)

         $counter = ((request('page')-1)*10) +1;
        else
        $counter = 1;
        @endphp

            @foreach ($purchases as $purchase)
                <tr>
                    <th>{{ $counter }}</th>
                    <td>{{ $purchase->vendor->name }}</td>
                    <td>{{ $purchase->name }}</td>
                        <td>{{ $purchase->qty }}</td>
                    <td>{{auth()->user()->currency}} {{ $purchase->price }}</td>
                    <td>{{auth()->user()->currency}} {{ $purchase->sale_price }}</td>
                    <td>{{ $purchase->created_at->setTimezone('asia/karachi')->format('d-m-Y g:i A') }}</td>

                    <td>
                        {{-- <a href="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"
                            class="box border border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary me-2">
                            <i class="bi bi-eye-fill"></i></a> --}}
                        <a href="{{ route('purchase.edit', $purchase->id) }}" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Edit"
                            class="box border border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary me-2">
                            <i class="bi bi-pencil"></i></a>
                    </td>
                </tr>
                @php
                $counter++;
            @endphp
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="8" >No record found</td>
            </tr>
        @endif

    </tbody>
</table>
