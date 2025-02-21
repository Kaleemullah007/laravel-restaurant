<div class="d-flex">
    @if($row->is_process == false)
        
    
    <a href="{{route('purchase-return.edit',$row->id)}}?page={{ $currentPage }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom" title="Edit"
        class="box border bg-white border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary mx-2 ">
        <i class="bi bi-pencil"></i>
    </a>
    @endif
</div>