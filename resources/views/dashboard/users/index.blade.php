@extends('layouts.dashboards')

@section('title','Admins')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Admin</li>
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
            <th>@if(Auth::user()->can('admin.create',Admin::class))<a href="{{route('dashboard.admins.create')}}" class="btn btn-sm btn-outline-primary">create</a>@endif</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        @forelse ($admins as $admin)
        <tr>


            <td>{{$admin->id}}</td>
            <td> <a href="{{route('dashboard.admins.show',$admin->id)}}">{{$admin->name}}</a> </td>
            <td>{{$admin->created_at}}</td>
            {{-- <td></td>
            <td></td> --}}
            <td>@can('admin.delete')<a href="{{route('dashboard.admins.edit',$admin->id)}}"class='btn btn-sm btn-outline-info'>edit</a>@endcan</td>
            <td>
                @can('admin.delete')
               <form action="{{route('dashboard.admins.destroy',$admin->id)}}" method="POST">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">delete</button>
                </form>
                @endcan
            </td>


            @empty
            <td colspan="5">there is not admin</td>

        </tr>
        @endforelse
    </tbody>
</table>
{{$admins->withQueryString()->links();}}
@endsection
