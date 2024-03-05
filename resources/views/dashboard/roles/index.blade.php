@extends('layouts.dashboards')

@section('title','Roles')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Role</li>
@endsection

@section('content')


<x-form.alert type='success'/>
<x-form.alert type='info'/>




<table class="table">
    <thead>
        <tr>

            <th>ID</th>
            <th>NAME ROLE</th>
            <th>CREATED_AT</th>
            <th>@if(Auth::user()->can('role.create',Role::class))<a href="{{route('dashboard.roles.create')}}" class="btn btn-sm btn-outline-primary">create</a>@endif</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        @forelse ($roles as $role)
        <tr>


            <td>{{$role->id}}</td>
            <td> <a href="{{route('dashboard.roles.show',$role->id)}}">{{$role->name}}</a> </td>
            <td>{{$role->created_at}}</td>
            {{-- <td></td>
            <td></td> --}}
            <td>@if(Auth::user()->can('role.update',Role::class))<a href="{{route('dashboard.roles.edit',$role->id)}}"class='btn btn-sm btn-outline-info'>edit</a>@endif</td>
            <td>
                @if(Auth::user()->can('role.delete',Role::class))
                <form action="{{route('dashboard.roles.destroy',$role->id)}}" method="POST">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">delete</button>
                </form>
                @endif
            </td>


            @empty
            <td colspan="5">there is not role</td>

        </tr>
        @endforelse
    </tbody>
</table>
{{$roles->withQueryString()->links();}}
@endsection
