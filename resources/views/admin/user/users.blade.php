@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Components</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Users</a></li>
    </ol>
</div>
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>User List</h3>
                    <h6>Total users {{$total_user}}</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>sl</th>
                                <th>name</th>
                                <th>email</th>
                                <th>Created at</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($get_all_user as $key =>$user)
                            <tr>
                                <td>{{$get_all_user->firstitem()+$key}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at->diffForHumans()}}</td>
                                <td>
                                <a href="{{route('user.delete',$user->id)}}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$get_all_user->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_code')
@if (session('delete'))
<script>
    Swal.fire(
  'Deleted!',
  '{{session('delete')}}',
  'success'
 )
</script>
@endif
@endsection
