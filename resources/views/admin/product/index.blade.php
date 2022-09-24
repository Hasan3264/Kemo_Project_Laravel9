{{-- @extends('layouts.dashboard')
@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">sub_category</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>add product</h3>
            </div>
            <div class="card-body">
                <form action="{{ url('/product/insert') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">category</label>
                                <select name="category_id" class="form-control" id="category">
                                    <option value="">--- Select Category -------</option>
                                    @foreach($categoryes as  $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">Sub category Name</label>
                                <select name="subcategory_id" class="form-control" id="subcategory">
                                    <option value="">----- Select Sub Category -----</option>
                                    @foreach($subcategory as  $sub_category)
                                    <option value="{{$sub_category->id}}">{{$sub_category->subcategory_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">product name</label>
                                <input type="text" name="product_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">product price</label>
                                <input type="number" name="product_price" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">Discount %</label>
                                <input type="number" name="discount" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">Short description</label>
                                <input type="text" name="short_des" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="" class="form-label">Long description</label>
                                <textarea type="text" name="long_des" class="form-control" id="summernote"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">Product Preview</label>
                                <input type="file" name="Product_preview" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="form-label">Product Thumbnails</label>
                                <input type="file" name="thumbnails[]" multiple class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <div class="form-group text-center">
                              <button type="submit" class="btn btn-primary">Add Product</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection
@section('js_code')
 @if (session('update'))
 <script>
     Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: '{{session('update')}}',
  showConfirmButton: false,
  timer: 1500
})
    //     Swal.fire(
    // 'done!',
    // '{{session('update')}}',
    // 'success'
    // )
</script>
 @endif
 //summer note
<script>
    $(document).ready(function() {
  $('#summernote').summernote();
});
</script>
//summer note
<script>

    $('#category').change(function (){
        var category_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
                    $.ajax({
                            type:'POST',
                            url:'/getsubcategory',
                            data:{'category_id': category_id},
                            success:function(data){
                                $('#subcategory').html(data);
                            }
                    });
    });
</script>

@endsection --}}
