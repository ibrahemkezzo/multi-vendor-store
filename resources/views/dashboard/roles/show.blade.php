@extends('layouts.dashboards')

@section('title', "$role->name")

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> <a href="{{route('dashboard.roles.index')}}"> role</a></li>
    <li class="breadcrumb-item active">{{$role->name}}</li>
    {{-- <pre></pre>
<div  >
    <a href="{{route('dashboard.roles.trash')}}" class="btn btn-sm btn-outline-warning">the deleteds</a>
</div>--}}
@endsection

@section('content')

    <table class="table">
        <thead>
            <tr>
                <th>NAME ABILITY</th>
                <th>TYPE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($abilities as $ability => $type)
            <tr>
                <td>{{$ability}}</td>
                <td>{{$type}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a class="btn btn-sm btn-outline-primary form-control" href="{{route('dashboard.roles.index')}}">back to roles</a>

@endsection
