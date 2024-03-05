@extends('layouts.dashboards')

@section('title','Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Category</li>
@endsection

@section('content')
<div  class="content ">
    <a href="{{route('dashboard.categories.trash')}}" class="btn btn-sm btn-outline-warning">the deleteds</a>
    <br>
    <br>
</div>


<x-form.alert type='success'/>
<x-form.alert type='info'/>



    <form action="{{URL::current()}}" method="GET" class="d-flex justify-content-between">
        <x-form.input name="name" placeholder="name" class="mx-2" :value="$request->name"/>
        <select name='status' class="form-control mx-2">
            <option value="" selected>ALL</option>
            <option value="active" @selected($request->status=='active')>Active</option>
            <option value="archived"  @selected($request->status=='archived')>Archived</option>
        </select>
        <button type="submit" class="btn btn-dark mx-2">Filter</button>
    </form>


<table class="table">
    <thead>
        <tr>

            <th>ID</th>
            <th>IMAGE</th>
            <th>NAME</th>
            <th>PARENT_ID</th>
            <th>PRODUCTS_COUNT</th>
            <th>status</th>
            <th>CREATED_AT</th>
            {{-- @dd(Auth::user()->can('create',Category::class)) --}}
            <th>@if(Auth::user()->can('create',Category::class))<a href="{{route('dashboard.categories.create')}}" class="btn btn-sm btn-outline-primary">create</a>@endif</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        @forelse ($categories as $category)
        <tr>


            <td>{{$category->id}}</td>
            <td><img src="{{asset('storage/'.$category->image)}}"alt="" width="80px" ></td>
            <td> <a href="{{route('dashboard.categories.show',$category->id)}}">{{$category->name}}</a> </td>
            <td>{{$category->parent->name}}</td>{{--{{$category->parent?$category->parent->name:'-'}}--}}
            <td>{{$category->product_count}}</td>
            <td>{{$category->status}}</td>
            <td>{{$category->created_at}}</td>
            {{-- <td></td>
            <td></td> --}}

            {{-- @dd(Auth::user()->hasAbility('category.update')) --}}
            <td>@can('update',$category)<a href="{{route('dashboard.categories.edit',$category->id)}}"class='btn btn-sm btn-outline-info'>edit</a>@endcan</td>
            <td>



                @if(Auth::user()->can('delete',$category))
               <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="POST">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">delete</button>
                </form>
                @endif
            </td>


            @empty
            <td colspan="8">there is not category</td>

        </tr>
        @endforelse
    </tbody>
</table>
{{$categories->withQueryString()->links();}}
@endsection
