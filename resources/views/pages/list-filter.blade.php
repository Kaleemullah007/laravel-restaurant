<div class="row d-flex mb-1 justify-content-center" id="filter-nav">
    <div class="col-11 @if(auth()->user()->user_type == 'admin') col-lg-12 col-md-12 @else col-lg-6 col-md-6 @endif  mt-1">
        <input type="text" name="daterange" value="{{date('m/01/Y')}} - {{date('m/d/Y')}}" 
        onChange="{{isset($functionName)?$functionName.'()':''}}" 
        class="form-control form-control-css getSales border-secondary ms-2 rounded"
        id="daterange" >
    </div>

 @if(auth()->user()->user_type == 'superadmin')
        @if(isset($admins))
    <div class="col-11 col-lg-6 col-md-6 mt-1">

       
        <select class="form-control form-control-css border-secondary ms-2 rounded" 
            name="admin" id="admin" onChange="{{isset($functionName)?$functionName.'()':''}}">
                    <option value="all" selected >All</option>

            @foreach ($admins as $admin)
            <option value="{{$admin->id}}"  @selected(session()->get('admin_id') == $admin->id)>{{$admin->name}}</option>
                
            @endforeach
            
        </select>
         </div>
        @endif
        @endif
   
</div>
