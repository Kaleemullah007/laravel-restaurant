@include('message')

<table class="table border table-striped align-middle">
    <thead>
        <tr>
            <th>{{ __('en.Id') }}</th>
            <th>{{ __('en.Raw Material') }}</th>
            <th>{{ __('en.Product') }}</th>
            <th>{{ __('en.Quantity') }}</th>
            <th>{{ __('en.Waste') }}</th>
            <th>{{ __('en.Action') }}</th>
        </tr>
    </thead>
    <tbody>

        @if ($productions->count() > 0)

        @php
         if(request('page')>1)

         $counter = ((request('page')-1)*10) +1;
        else
        $counter = 1;
        @endphp
        @foreach ($productions as $production)
            <tr>
                <th>{{ $counter }}</th>
                <td>{{ $production->RawMaterial->name??null }}</td>
                <td>{{ $production->Product->name??null }}</td>
                <td>{{ $production->qty }}</td>
                <td>{{ $production->wastage_qty }}</td>
                <td>
                    <a href="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"
                        class="box border border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary me-2">
                        <i class="bi bi-eye-fill"></i></a>
                    <a href="{{ route('production.edit', $production->id) }}" data-bs-toggle="tooltip"
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
            <td class="text-center" colspan="6" >No record found</td>
        </tr>
    @endif
    </tbody>
</table>
