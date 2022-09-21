@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('category')}}">Category</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Category Edit</a></li>
    </ol>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Update Category</h3>
                </div>

                <div class="card-body">
                    <form action="{{route('category.edit')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="" clas="form-label">category Name</label>
                            <input type="hidden" class="form-control" name="id" value="{{$cat_info->id}}">
                            <input type="text" class="form-control" name="category_name"
                                value="{{$cat_info->category_name}}">
                            @error('category_name')
                            <strong class="text-danger">{{$message}}</strong>
                            @enderror
                            @if(session('Categoryerr'))
                            <strong class="text-danger">{{session('Categoryerr')}}</strong>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" clas="form-label">category Photo</label>
                            <input type="file" class="form-control" name="category_photo"
                            value="{{$cat_info->category_photo}}">
                            @error('category_photo')
                            <strong class="text-danger">{{$message}}</strong>
                            @enderror
                            @if(session('category_photo'))
                            <strong class="text-danger">{{session('category_photo')}}</strong>
                            @endif
                        </div>
                        <div style="width: 80px"><img class="img-fluid" src="{{asset('/uploads/category')}}/{{ $cat_info->category_photo }}" alt=""></div>    
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary edit">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection
 @section('js_code')
 @if (session('succes'))
  <script>
      Swal.fire(
    'Updated!',
    '{{session('succes')}}',
    'success'
   )
  </script>
@endif
{{-- <script>
$(document).ready(function(){
$('.delete').click(function(){
var link=$(this).val();
Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
  if (result.isConfirmed) {
     window.location.href = link;

  }
  })
})
});
</script>
@if (session('delete'))
<script>
Swal.fire(
'Deleted!',
'{{session('delete')}}',
'success'
)
</script> --}}
{{-- @endif --}}



@endsection 
