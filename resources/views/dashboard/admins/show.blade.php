@extends('layouts.dashboards')

@section('title', "$admin->id  -  $admin->name")

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> <a href="{{route('dashboard.admins.index')}}"> admin</a></li>
    <li class="breadcrumb-item active">{{$admin->name}}</li>
    {{-- <pre></pre>
<div  >
    <a href="{{route('dashboard.admins.trash')}}" class="btn btn-sm btn-outline-warning">the deleteds</a>
</div>--}}
@endsection

@section('content')
<div class="content container-fluid col-lg-10 ">
    <table class="table col-md-12">
        <thead>
            <tr>
                <th>NAME ROLE</th>

                <td>
                @foreach ($roles as $role)
                    {{$role.' , '}}
                @endforeach
                </td>
            </tr>
            <tr>
                <th>STORE OWNER</th>
                <td> {{isset($admin->store_id)?$admin->store->name:'no store'}}</td>
            </tr>
            <tr>
                <th>EMAIL</th>
                <td> {{isset($admin->email)?$admin->email:'no email'}}</td>
            </tr>
            <tr>
                <th>USER NAME</th>
                <td> {{isset($admin->username)?$admin->username:'no username'}}</td>
            </tr>
        </thead>
        <tbody>

            <tr>

            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="form-group col-md-3">
            <a class="btn btn-outline-secondary form-control" href="{{route('dashboard.admins.index')}}">back to admins</a>
        </div>
        <div class="form-group col-md-3">
            <a class="btn btn-outline-primary form-control" href="{{route('dashboard.admins.edit',$admin->id)}}">update this admin</a>
        </div>

    </div>
</div>
@endsection
