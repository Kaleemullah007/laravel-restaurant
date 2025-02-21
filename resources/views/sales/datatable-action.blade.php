<a href="{{ route('sale.show', $row->id) }}?page={{ $currentPage }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
    title="View" class="box border border-1 border-secondary rounded-pill px-2 py-1 fs-6 link-secondary">
    <i class="bi bi-eye-fill"></i></a>
<a href="{{ route('sale.edit', $row->id) }}?page={{ $currentPage }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
    title="Edit" class="box border border-1 border-secondary rounded-pill px-2 py-1 fs-6 link-secondary mx-2">
    <i class="bi bi-pencil"></i></a>
