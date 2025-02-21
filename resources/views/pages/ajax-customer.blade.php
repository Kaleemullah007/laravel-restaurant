
@include('message')

<table class="table border align-middle">
    <thead>
        <tr>
            <th>{{__('en.Id')}}</th>
            <th>{{__('en.Customer')}}</th>
            <th>{{__('en.Role')}}</th>
            <th>{{__('Balance Due')}}</th>
            <th>{{__('en.Phone')}}</th>
            <th>{{__('en.Email')}}</th>
            <th>{{__('en.Action')}}</th>
        </tr>

    </thead>
    <tbody>
        @if ($customers->count() > 0)

        @php
         if(request('page')>1)

        $counter = ((request('page')-1)*10) +1;
        else
        $counter = 1;
        @endphp
        @foreach ($customers as $customer )
        @php
            $amount = $customer->customer_sale_sum_remaining_amount - $customer->desposit_sum_sum_amount
        @endphp
            <tr  @if ($amount > 0) class="bg-alert" @else class="bg-transparent"  @endif >
                <td>{{$counter}}</td>
                <td>{{$customer->name}} {{$customer->start_date }} @if(!is_null($customer->end_date)) - {{$customer->end_date}} @endif </td>
                <td>{{ ($customer->is_tester)?'Tester':$customer->user_type}}</td>
                <td>{{$amount}} @if ($amount < 0 )
                    <br><code>Minus Means Surplus</code>
                @endif</td>
                <td>{{$customer->phone}}</td>
                <td>{{$customer->email}}</td>
                <td>
                    <a href="{{ route('sale.index',['customer_id'=>$customer->id]) }} " data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"
                        class="box border bg-white border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary">
                        <i class="bi bi-eye-fill"></i></a>
                    <a href="{{route('customer.edit',$customer->id)}}?page={{request('page',1)}}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"
                        class="box border bg-white border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary mx-2">
                        <i class="bi bi-pencil"></i></a>
                    <a href="{{route('customer.show',$customer->id)}}?page={{request('page',1)}}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"
                            class="box border bg-white border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary ">
                            <i class="bi bi-plus"></i></a>
                </td>
            </tr>
            @php
            $counter++;
        @endphp
        @endforeach
        @else
        <tr>
            <td class="text-center" colspan="7" >No record found</td>
        </tr>
        @endif

    </tbody>
</table>
