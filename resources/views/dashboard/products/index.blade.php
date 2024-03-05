@extends('layouts.dashboards')

@section('title','Products')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products</li>
<pre></pre>
{{-- <div  >
    <a href="{{route('dashboard.products.trash')}}" class="btn btn-sm btn-outline-warning">the deleteds</a>
</div> --}}
@endsection

@section('content')

@if (session()->has('success'))
<div class="alert alert-success">
{{session('success')}}
</div>
@endif
@if (session()->has('info'))
<div class="alert alert-danger">
{{session('info')}}
</div>
@endif


    {{-- <form action="{{URL::current()}}" method="GET" class="d-flex justify-content-between">
        <x-form.input name="name" placeholder="name" class="mx-2" :value="$request->name"/>
        <select name='status' class="form-control mx-2">
            <option value="" selected>ALL</option>
            <option value="active" @selected($request->status=='active')>Active</option>
            <option value="archived"  @selected($request->status=='archived')>Archived</option>
        </select>
        <button type="submit" class="btn btn-dark mx-2">Filter</button>
    </form> --}}


<table class="table">
    <thead>
        <tr>

            <th>ID</th>
            <th>IMAGE</th>
            <th>NAME</th>
            <th>STORE</th>
            <th>CATEGORY</th>
            <th>STATUS</th>
            <th>PRICE</th>
            <th>CREATED_AT</th>
            {{-- @can('create',Product::class)
            @dd(true)
            @endcan --}}
            {{-- @dd(Auth::user()->can('view',Product::class))
            @dd(Auth::user()->hasAbility('product.create')) --}}
            @if (Auth::user()->can('create',Product::class))
            <th><a href="{{route('dashboard.products.create')}}" class="btn btn-sm btn-outline-primary">create</a></th>
            @endif
            <th></th>
        </tr>
    </thead>
    <tbody>

        @forelse ($products as $product)
        <tr>


            <td>{{$product->id}}</td>
            <td><img src="{{asset('storage/'.$product->image)}}"alt="" width="80px" ></td>
            <td> <a href="{{route('dashboard.products.show',$product->id)}}"> {{$product->name}} </a></td>
            <td>{{$product->store->name}}</td>
            <td>{{$product->category->name}}</td>
            <td>{{$product->status}}</td>
            <td>{{$product->price}}</td>
            <td>{{$product->created_at}}</td>
            @if (Auth::user()->can('update',$product))
            <td><a href="{{route('dashboard.products.edit',$product->id)}}"class='btn btn-sm btn-outline-info'>edit</a></td>
            @endif
            @if (Auth::user()->can('delete',$product))
            <td>
                <form action="{{route('dashboard.products.destroy',$product->id)}}" method="POST">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">delete</button>
                </form>
            </td>
            @endif


            @empty
            <td colspan="10">there is not product</td>

        </tr>
        @endforelse
    </tbody>
</table>
{{$products->withQueryString()->links();}}
@endsection
