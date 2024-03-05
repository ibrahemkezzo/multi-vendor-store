@extends('layouts.dashboards')

@section('title', "$category->name")

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> <a href="{{route('dashboard.categories.index')}}"> category</a></li>
    <li class="breadcrumb-item active">{{$category->name}}</li>
    {{-- <pre></pre>
<div  >
    <a href="{{route('dashboard.categories.trash')}}" class="btn btn-sm btn-outline-warning">the deleteds</a>
</div>--}}
@endsection

@section('content')

    <table class="table">
        <thead>
            <tr>

                <th>IMAGE</th>
                <th>NAME</th>
                <th>STORE</th>
                <th>STATUS</th>
                <th>CREATED_AT</th>

            </tr>
        </thead>
        <tbody>
            @php
                $products=$category->products()->with(['store'])->latest()->paginate(5);
            @endphp
            @forelse ($products as $product)
                <tr>


                    <td><img src="{{ asset('storage/' . $product->image) }}"alt="" width="80px"></td>
                    <td> {{ $product->name }}</a> </td>
                    <td> {{ $product->store->name }}</a> </td>
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->created_at }}</td>

                @empty
                    <td colspan="5">there is not product</td>

                </tr>
            @endforelse
        </tbody>
    </table>
{{$products->links()}}

@endsection
