<div class="d-flex">
                        {{-- <a href="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"
                            class="box border bg-white border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary">
                            <i class="bi bi-eye-fill"></i></a> --}}
                        <a href="{{route('product.edit',$row->id)}}?page={{ $currentPage }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"
                            class="box border bg-white border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary mx-2 ">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form class="" action="{{ route('product.destroy', $row->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"  data-bs-toggle="tooltip" id="{{$row->id}}row?page={{ $currentPage }}" data-bs-placement="bottom" title="Delete"
                                class="box border bg-white border-1 border-secondary rounded-pill px-2 py-0 fs-6 link-secondary delete">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                        </div>