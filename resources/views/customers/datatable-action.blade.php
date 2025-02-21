
@if(($row->user_type == 'customer' && auth()->user()->user_type == 'admin') || auth()->user()->user_type == 'superadmin')
@if($row->user_type == 'customer')
<a href="{{ route('sale.index', ['customer_id' => $row->id]) }} " data-bs-toggle="tooltip" data-bs-placement="bottom"
    title="View" class="box border bg-white border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary">
    <i class="bi bi-eye-fill"></i></a>
    
@endif

@elseif(($row->user_type == 'vendor' && auth()->user()->user_type == 'admin') ||  auth()->user()->user_type == 'superadmin')
@if($row->user_type == 'vendor')
<a href="{{ route('purchase.index', ['vendor_id' => $row->id]) }} " data-bs-toggle="tooltip" data-bs-placement="bottom"
    title="View" class="box border bg-white border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary">
    <i class="bi bi-eye-fill"></i></a>
    @endif
@endif
<a href="{{ route('customer.edit', $row->id) }}?page={{ $currentPage  }}" data-bs-toggle="tooltip"
    data-bs-placement="bottom" title="Edit"
    class="box border bg-white border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary mx-2">
    <i class="bi bi-pencil"></i></a>
<a href="{{ route('customer.show', $row->id) }}?page={{ $currentPage  }}" data-bs-toggle="tooltip"
    data-bs-placement="bottom" title="Edit"
    class="box border bg-white border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary ">
    <i class="bi bi-plus"></i></a>
