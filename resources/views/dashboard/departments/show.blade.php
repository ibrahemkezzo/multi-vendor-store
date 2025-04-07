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
            @php
                $products=$department->products()->with(['store'])->latest()->paginate(5);
            @endphp
            @forelse ($products as $product)
                <tr>


                    <td><img src="{{ asset('storage/' . $store->image) }}"alt="" width="80px"></td>
                    <td> {{ $store->name }}</a> </td>
                    <td>{{ $product->status }}</td>

                @empty
                    <td colspan="5">there is not stores</td>

                </tr>
            @endforelse
        </tbody>
    </table>
{{$products->links()}}

@endsection
