@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Subcategory</a></li>
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
                <form id="catmarkdel">
                    @csrf
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><input id="checkAll" type="checkbox">mark all
                                </th>
                                <td>Sl</td>
                                <td>Category name</td>
                                <td>Sub Category name</td>
                                <td>ceated at</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                     <button  data-url="" type="button" id="trushcat" class='btn
                    btn-danger'>Trush All</button>
                    <a href="">Trushed Categories</a> 
                </form>
            </div>
        </div>

    </div>

    <div class="col-lg-4 ">
        <div class="card h-auto">
            <div class="card-header">
                <h3>Add sub category</h3>
            </div>
            @if (session('Categoryerr'))
            <strong class="text-danger">{{session('Categoryerr')}}</strong>
            @endif
            <div class="card-body">
                <form name="InsertSubForm" id="InsertSubForm">


                    @csrf
                    <div class="form-group">
                        <label for="" clas="form-label">Sub category Name</label>
                        <input type="text" id="name" class="form-control" name="Sub_category_name">
                        @error('category_name')
                        <strong class="text-danger">{{$message}}</strong>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Select Category</label>
                        <select id="category_id" name="category_id" class="form-control">
                            <option value="">-- select category --</option>
                        </select>
                        @error('category_id')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <button type="button" onclick="subinsert()" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection




@section('js_code')
<script>
    function subinsert() {
        if ($('#name').val() == '') {
            $('#name').addClass('has-error');
            return false;
        } else if ($('#category_id').val() == '') {
            Swal.fire('Plase Select a Category')
            return false;
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var value = $('#InsertSubForm').serialize();
            $.ajax({
                url: "{{route('subcat.add')}}",
                type: 'POST',
                data: value,
                success: function (data) {
                    Swal.fire(
                        'Done!',
                        data.success,
                        'success'
                    )
                }
            });
        }
    }

</script>
<script>
    // category fetch
    fetchcategory();

    function fetchcategory() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/get/gategory",
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                // console.log(response.categores)
                $.each(response.categores, function (key, item) {
                    $('tbody').append( '<tr>\
                        <td> '+item.id+'</td>\ 
                         <td>'+item.sub_category_name+'</td>\
                         <td></td> \
                         <td>  ->created_at -> diffForHumans() </td> \
                        <td><a href = "javascript:void(0)" data-url=""class = "btn btn-danger shadow btn-xs sharp delete" > < i class ="fa fa-trash"></i></a >\
                        <hr>\
                        <a data-tr = "tr_'+item.id+'" href = "" class = "btn btn-info shadow btn-xs sharp" > < i class ="fa fa-pencil"></i></a></td>\
                        </tr>'
                        '<option value="">' + item.category_name + '</option>'
                    );
                });
            }
        });
    }

</script>
<script>
    // category fetch
    fetch_subcatgory();

    function fetch_subcatgory() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/get/sub_gategory",
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                // console.log(response.categores)
                $.each(response.subcategory, function (key, item) {
                    $('select').append(
                        '<option value="' + item.id + '">' + item.category_name + '</option>'
                    );
                });
            }
        });
    }

</script>
{{-- <script>
 $('.delete').on('click', function(){
           var userURL = $(this).data('url');
            var trObj = $(this);
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
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
            }); 
      
 });
</script>
<script>
      $('#trushcat').on('click', function() {
      var allVals =[];
      $(".xx:checked").each(function(){
           allVals.push($(this).attr('data-id'));
      });
      if(allVals.length<=0){
        Swal.fire(
            'Wait!',
            'Select Row',
            'Thanks'
            ) 
      }
      else{
         Swal.fire({
             title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
             confirmButtonText: 'Yes, delete it!'
            }).then((result)=>{
                 if(result.isConfirmed){
                     var join_selected_values = allVals.join(","); 
                     $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function(data){
                            if (data['success']) {
                                $(".xx:checked").each(function() {  
                                    $(this).parents("tr").remove();
                                });
                                    Swal.fire(
                                        'Deleted!',
                                        'Deleted success',
                                        'success'
                                    )
                            }
                            else if (data['error']) {
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


      <!--=======------==== checked all js=========-----======== -->
            <script>
                $("#checkAll").click(function(){
                $('.xx').not(this).prop('checked', this.checked);
            });

            </script>
  <!-- ======== checked all js end=============== -->
  --}}
@endsection
