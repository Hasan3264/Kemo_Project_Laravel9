@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('category')}}">Category</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Trash</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-11">
        <div class="card m-auto">
            <div class="card-header">
                <h3>Tresh Counter</h3>
                <p>Deleted cetegoryes 
                    <br> You can Restore this</p>
            </div>

            <div class="card-body">
                <form action="{{route('hard.delete')}}" method="POST">
                    @csrf
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td><input id="trash_mark" type="checkbox">mark all</td>
                                <td>Sl</td>
                                <td>added by</td>
                                <td>category name</td>
                                <td>ceated at</td>
                                <td>Deleted at</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trash_cat as $key=> $trash)
                            <tr>

                                <td> <input type="checkbox" class="xxy" name="mark[]" value="{{$trash->id}}"></td>
                                <td>{{$key+1}}</td>
                                <td> @php
                                    if(App\Models\User::where('id', $trash->user_id)->exists()){
                                    echo $trash->relation_user->name;
                                    }
                                    else{
                                    echo 'N\A';
                                    }
                                    @endphp</td>
                                <td>{{$trash->category_name}}</td>
                                <td>{{$trash->created_at->diffForHumans()}}</td>
                                <td>{{$trash->deleted_at->diffForHumans()}}</td>
                                <td>
                                    <button type="button" value="{{route('re.store', $trash->id)}}"  class="restore btn btn-success shadow btn-xs sharp mt-2">Re</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class='btn btn-primary'>Delete All</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection




@section('js_code')
<script>
    $("#trash_mark").click(function () {
        $('.xxy').not(this).prop('checked', this.checked);
    });

</script>
@if (session('allrestore'))
<script>
    Swal.fire(
    'Restored!',
    '{{session('allrestore')}}',
    'success'
)
</script>
@endif
@if (session('alldelete'))
<script>
    Swal.fire(
    'Deleted!',
    '{{session('delete')}}',
    'success'
)
</script>
@endif
<script>
    $(document).ready(function(){
         $('.restore').click(function(){
            var link=$(this).val();
            Swal.fire({
                  title: 'Are you sure?',
                  text: "To Store Again This",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, Restore it!'
                  }).then((result) => {
                  if (result.isConfirmed) {
                     window.location.href = link;

                  }
                  })
         })
   });
</script>
@endsection
