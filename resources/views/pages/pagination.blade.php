<div  id="searchable_pagination">
<div class="row mb-2 justify-content-center">
    @if (isset($paginate))
    {{-- <div class="col-lg-4 col-md-6 col-12 mt-2 flex-row d-flex">
        <span class="mt-1">{{__('en.Rows Per Page')}} :</span>
        <select class="form-select w-50 ms-2 border-secondary">
            <option selected>10</option>
            <option value="1">20</option>
            <option value="2">30</option>
            <option value="3">50</option>
            <option value="4">{{__('en.All')}}</option>
        </select>
    </div> --}}
    @endif
    <div class="col-lg-3 col-md-4 col-12 mt-2 ">
        @if (isset($paginate))
        {{$paginate->onEachSide(2)->links()}}
        @endif

    </div>


</div>
</div>
