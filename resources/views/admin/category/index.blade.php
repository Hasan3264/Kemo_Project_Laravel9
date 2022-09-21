@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Category</a></li>
    </ol>
</div>

    <div class="row">
        <div class="col-lg-8 col-sm-8 m-auto">
              <div class="card">
                  <div class="card-header">
                       <h3>Category Name</h3>
                  </div>
                  <div class="card-body">
                      <h2 class="text-danger" id="markerror"></h2>
                  <form   action="{{url('/mark/delete')}}" method="POST">
                      @csrf
                            <table  class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input id="checkAll"  type="checkbox">mark all
                                        </th>
                                        <td>Sl</td>
                                        <td>added by</td>
                                        <td>Category name</td>
                                        <td>Category Photo</td>
                                        <td>ceated at</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($getcat as $key=> $cat)
                                    <tr>

                                        <td>
                                            <input  type="checkbox" class="xx" name="mark[]" value="{{$cat->id}}">
                                        </td>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            @php
                                               if(App\Models\User::where('id', $cat->user_id)->exists()){
                                                    echo $cat->relation_user->name;
                                               }
                                               else{
                                                echo 'N\A';
                                               }
                                            @endphp
                                        </td>
                                        <td>{{$cat->category_name}}</td>
                                        <td width="50" ><img class="img-fluid" src="{{asset('/uploads/category')}}/{{ $cat->category_photo }}" alt=""></td>
                                        <td>{{$cat->created_at->diffForHumans()}}</td>
                                        <td>
                                            <button value="{{route('cat.softdelete', $cat->id)}}" type="button" class="btn btn-danger shadow btn-xs sharp delete"><i class="fa fa-trash"></i></button>
                                            <hr>
                                             <a href="{{route('cat.edit', $cat->id)}}" class="btn btn-info shadow btn-xs sharp"><i class="fa fa-pencil"></i></a> 
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button  id="trushcat" class='btn btn-danger'>Trush All</button>
                            <a href="{{route('trushed')}}">Trushed Categories</a>
                        </form>
                  </div>
              </div>

        </div>
      
        <div class="col-lg-4 ">
           <div class="card h-auto">
           <div class="card-header">
                <h3>Add category</h3>
            </div>
            @if (session('Categoryerr'))
                <strong class="text-danger">{{session('Categoryerr')}}</strong>
            @endif
            <div class="card-body">
                <form action="{{route('add.route')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="" clas="form-label">category Name</label>
                        <input type="text"  class="form-control" name="category_name">
                        @error('category_name')
                           <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        
                    </div>
                    <div class="form-group">
                        <label for="" clas="form-label">category Photo</label>
                        <input type="file"  class="form-control" name="category_photo">
                        @error('category_photo')
                           <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        @if (session('category_photo'))
                            <strong class="text-danger">{{session('category_photo')}}</strong>
                        @endif
                        
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
           </div>
        </div>
    </div>
    

@endsection




@section('js_code')
<script>
    $('#trushcat').on('click', function(){
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
                $("#trushcat").attr({
                    "type" : "button",
                });
              

            }
        })

    });
    
</script>
@if (session('succes'))
  <script>
      Swal.fire(
    'Added!',
    '{{session('succes')}}',
    'success'
   )
  </script>
@endif


<script>
    $(document).ready(function(){
         $('.delete').click(function(){
            var link=$(this).val();
            Swal.fire({
                  title: 'Are you sure?',
                  text: "To Delete  this!",
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
  </script>
@endif
      <!--=======------==== checked all js=========-----======== -->
            <script>
                $("#checkAll").click(function(){
                $('.xx').not(this).prop('checked', this.checked);
            });

            </script>

            @if (session('alldelete'))
                <script>
                    Swal.fire(
                    'Deleted!',
                    '{{session('delete')}}',
                    'success'
                )
                </script>
                @endif
            @if (session('allrestore'))
                <script>
                    Swal.fire(
                    'Deleted!',
                    '{{session('allrestore')}}',
                    'success'
                )
                </script>
                @endif
  <!-- ======== checked all js end=============== -->
 
@endsection
