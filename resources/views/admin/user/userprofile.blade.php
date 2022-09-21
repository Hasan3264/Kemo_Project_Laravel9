

@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Deshboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">User Profile</a></li>
    </ol>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-4">
           <div class="card h-auto">
           <div class="card-header">
                <h3>User Name</h3>
            </div>

            <div class="card-body">
                 <form name="Upnmae" id="Upname" class="form">
                     @csrf
                     <div class="form-group">
                         <label for="" class="form-label">name</label>
                          <input type="text" class="form-control" name="name" id="username" value="{{Auth::user()->name}}">
                          @error('old_password')
                          <strong class="text-danger pt-3">{{$message}}</strong>
                          @enderror
                     </div>
                    <div class="form-group">
                        <button type="button" onclick="login()" class="btn btn-primary">Update</button>
                    </div>
                 </form>
            </div>
           </div>
        </div>
      

        <div class="col-lg-4">
           <div class="card h-auto">
           <div class="card-header">
                <h3>User Password</h3>
            </div>

            <div class="card-body">
                 <form action="{{route('pass.update')}}" method="POST">
                     @csrf
                     @if (session('updated_pass'))
                      <strong class="text-danger pt-3">{{session('updated_pass')}}</strong>
                     @endif
                     <div class="form-group">
                         <label for="" class="form-label">Current Password</label>
                          <input type="password" class="form-control" name="old_password">
                          @if (session('wrong_pass'))
                           <strong class="text-danger pt-3">{{session('wrong_pass')}}</strong>
                          @endif
                          @error('old_password')
                          <strong class="text-danger pt-3">{{$message}}</strong>
                          @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">New Password</label>
                            <input type="password" class="form-control" name="password">
                            @error('password')
                                <p class="alert alert_danger">password Not Valid</p>
                            @enderror
                            @if (session('exiest_pass'))
                             <strong class="text-danger pt-3">{{session('exiest_pass')}}</strong>
                            @endif
                          @error('password')
                          <strong class="text-danger pt-3">{{$message}}</strong>
                          @enderror
                          </div>
                          <div class="form-group">
                          <label for="" class="form-label">Confirm Password</label>
                          <input type="password" class="form-control" name="password_confirmation">
                          @error('password_confirmation')
                          <strong class="text-danger pt-3">{{$message}}</strong>
                          @enderror
                     </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                 </form>
            </div>
           </div>
        </div>
        <div class="col-lg-4">
           <div class="card h-auto">
           <div class="card-header">
                <h3>User Photo</h3>
            </div>

            <div class="card-body">
                 <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="form-group">
                         <label for="" class="form-label">Update Photo</label>
                          <input type="file" class="form-control" name="profile_photo" placeholder="Your Photo">
                          @if (session('profile_photo'))
                           <strong class="text-danger pt-3">{{session('profile_photo')}}</strong>
                          @endif
                          @error('profile_photo')
                          <strong class="text-danger pt-3">{{$message}}</strong>
                          @enderror
                     </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                 </form>
            </div>
           </div>
        </div>
    </div>
</div>

@endsection
@section('js_code')

@if (session('Update'))
  <script>
      Swal.fire(
    'Updated!',
    '{{session('Update')}}',
    'success'
   )
  </script>
@endif

@if (session('update_photo'))
  <script>
      Swal.fire(
    'Updated!',
    '{{session('update_photo')}}',
    'success'
   )
  </script>
@endif
@if (session('updated_pass'))
  <script>
      Swal.fire(
    'Updated!',
    '{{session('updated_pass')}}',
    'success'
   )
  </script>
@endif
<script>
    function login(){
       if($('#username').val() =="")
       {
           $('#username').addClass('has-error');
           return false;
       }
       else{
        $('#username').removeClass('has-error');
          var data =$("#Upname").serialize();
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
         });
         $.ajax({
             type: 'POST',
             url: "/upname",
             data: data,
             success:function(response){
                 console.log(response);
                 if (response=='user_id'){
                    Swal.fire(
                        'Updated!',
                        'Your name was updated',
                        'success'
                    )
                 }
             }
         });
       }
    }
 </script>

@endsection
 