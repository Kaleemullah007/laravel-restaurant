@php
if($row->user_type == 'customer'){
$amount = $row->customer_sale_sum_remaining_amount - $row->desposit_sum_sum_amount;
@endphp

{{$amount}}     @if ($amount < 0 )
                    <br><code>Minus Means Surplus</code> // Customer given advance to shop keeper
              
                    @elseif ($amount > 0 )
                    Recievable  // Customer has to pay to Shop keeper
                    @endif
     @php
    }     
     
    
    elseif($row->user_type == 'vendor'){
        $amount = $row->vendor_produdct_purchases_sum_remaining_amount - $row->desposit_sum_sum_amount;
@endphp

{{$amount}} @if ($amount < 0 )
                    <br><code>Minus Means Surplus </code> // Owner has given extra amount to Vendor
                    @elseif ($amount > 0 )
                    Payable   // Owner has to pay to Vendor
                @endif
                @php
    }

@endphp