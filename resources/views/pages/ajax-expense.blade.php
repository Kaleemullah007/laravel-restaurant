@include('message')
<table class="table border table-striped align-middle">
    <thead>
        <tr>
            <th>{{__('en.Id')}}</th>
            <th>{{__('en.Name')}}</th>
            <th>{{__('en.Amount')}}</th>
            <th>{{__('en.Date')}}</th>
            <th>{{__('en.Action')}}</th>
        </tr>
    </thead>
    <tbody>
        @if ($expenses->count() > 0)

        @php
         if(request('page')>1)

         $counter = ((request('page')-1)*10) +1;
        else
        $counter = 1;
        @endphp

        @foreach ($expenses as $expense )
            <tr>
                <th>{{$counter}}</th>
                <td>{{$expense->name}}</td>
                <td>{{auth()->user()->currency}} {{$expense->amount}}</td>
                <td>{{$expense->date}}</td>
                <td>
                    {{-- <a href="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"
                        class="box border border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary">
                        <i class="bi bi-eye-fill"></i></a> --}}
                    <a href="{{route('expense.edit',$expense->id)}}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"
                        class="box border border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary mx-2">
                        <i class="bi bi-pencil"></i></a>
                </td>
            </tr>
            @php
            $counter++;
        @endphp
        @endforeach
    @else
        <tr>
            <td class="text-center" colspan="5" >No record found</td>
        </tr>
    @endif

    </tbody>
</table>
