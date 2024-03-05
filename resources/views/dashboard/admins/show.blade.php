@extends('layouts.dashboards')

@section('title', "$admin->name")

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

    <table class="table">
        <thead>
            <tr>
                <th>NAME ROLE</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
            <tr>
                <td>{{$role}}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <a class="btn btn-sm btn-outline-primary form-control" href="{{route('dashboard.admins.index')}}">back to admins</a>

@endsection
