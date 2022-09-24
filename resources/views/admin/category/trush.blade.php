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
                <form id="catmarkdel" >
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
                            <tr id="tr_{{$trash->id}}">

                                <td> <input type="checkbox" class="xxy" data-id="{{$trash->id}}" name="mark[]" value="{{$trash->id}}"></td>
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
                                    <a href="javascript:void(0)" data-url="{{route('re.store', $trash->id)}}" class="btn btn-danger shadow btn-xs sharp restore">Re</a>
                                    <a href="" data-tr="tr_{{$trash->id}}"></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" data-url="{{url('/hard/delete')}}" type="button"  id="trushcat"  class='btn btn-primary'>Delete All</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection




@section('js_code')
<script>
      $('#trushcat').on('click', function() {
            var allVals = [];  
            $(".xxy:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  
            if(allVals.length <=0)  
            {  
                alert("Please select row.");  
            }  else {  
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
                var url = $(this).attr('data-id');
                    var join_selected_values = allVals.join(","); 
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                     success: function (data) {
                            if (data['success']) {
                                $(".xxy:checked").each(function() {  
                                    $(this).parents("tr").remove();
                                });
                                    Swal.fire(
                                        'Deleted!',
                                        'Deleted success',
                                        'success'
                                    )
                            } else if (data['error']) {
                                        Swal.fire(
                                        'Error',
                                        'Something Wrong!',
                                        'success'
                                         )
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });
                  $.each(allVals, function( index, value ) {
                      $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }
      });  
            }  
        });
</script>
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
            var userURL = $(this).data('url');
            var trObj = $(this);
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
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
                    $.ajax({
                        url: userURL,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                             trObj.parents("tr").hide(),2000;
                             Swal.fire(
                                        'Done!',
                                        data.success,
                                        'success'
                                    )
                         }
                });

                  }
                  })
         })
   });
</script>
@endsection
