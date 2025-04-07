@extends('layouts.dashboards')

@section('title','Users')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">User</li>
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
            <th>@if(Auth::user()->can('user.create',User::class))<a href="{{route('dashboard.users.create')}}" class="btn btn-sm btn-outline-primary">create</a>@endif</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        @forelse ($users as $user)
        <tr>


            <td>{{$user->id}}</td>
            <td> <a href="{{route('dashboard.users.show',$user->id)}}">{{$user->name}}</a> </td>
            <td>{{$user->created_at}}</td>
            {{-- <td></td>
            <td></td> --}}
            <td>@can('user.delete')<a href="{{route('dashboard.users.edit',$user->id)}}"class='btn btn-sm btn-outline-info'>edit</a>@endcan</td>
            <td>
                @can('user.delete')
               <form action="{{route('dashboard.users.destroy',$user->id)}}" method="POST">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">delete</button>
                </form>
                @endcan
            </td>


            @empty
            <td colspan="5">there is not user</td>

        </tr>
        @endforelse
    </tbody>
</table>
{{$users->withQueryString()->links();}}
@endsection
