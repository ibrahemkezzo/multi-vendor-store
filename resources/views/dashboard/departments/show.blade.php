@extends('layouts.dashboards')

@section('title', "$department->name")

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> <a href="{{route('dashboard.departments.index')}}"> department</a></li>
    <li class="breadcrumb-item active">{{$department->name}}</li>
    {{-- <pre></pre>
<div  >
    <a href="{{route('dashboard.departments.trash')}}" class="btn btn-sm btn-outline-warning">the deleteds</a>
</div>--}}
@endsection

@section('content')

    <table class="table">
        <thead>
            <tr>

                <th>IMAGE</th>
                <th>NAME STORE</th>
                <th>STATUS</th>

            </tr>
        </thead>
        <tbody>
            @forelse ($stores as $store)
                <tr>


                    <td><img src="{{ asset('storage/' . $store->cover_image) }}"alt="" width="80px"></td>
                    <td><a href="{{route('dashboard.stores.show',$store->id)}}"> {{ $store->name }}</a> </td>
                    <td>{{ $store->status }}</td>

                @empty
                    <td colspan="5">there is not stores</td>

                </tr>
            @endforelse
        </tbody>
    </table>
{{$stores->links()}}

@endsection
