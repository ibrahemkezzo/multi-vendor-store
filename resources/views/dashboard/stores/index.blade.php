@extends('layouts.dashboards')

@section('title','Stores')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Store</li>
@endsection

@section('content')
{{-- <div  class="content ">
    <a href="{{route('dashboard.stores.trash')}}" class="btn btn-sm btn-outline-warning">the deleteds</a>
    <br>
    <br>
</div> --}}


<x-form.alert type='success'/>
<x-form.alert type='info'/>



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
            <th>LOGO</th>
            <th>COVER</th>
            <th>NAME</th>
            <th>DEPARTMENT</th>
            <th>PRODUCTS_COUNT</th>
            <th>STATE</th>
            {{-- @dd(Auth::user()->can('create',Store::class)) --}}
            <th>@if(Auth::user()->can('create',Store::class))<a href="{{route('dashboard.stores.create')}}" class="btn btn-sm btn-outline-primary">create</a>@endif</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        @forelse ($stores as $store)
        <tr>


            <td>{{$store->id}}</td>
            <td><img src="{{asset('storage/'.$store->logo_image)}}"alt="" width="80px" ></td>
            <td><img src="{{asset('storage/'.$store->cover_image)}}"alt="" width="80px" ></td>
            <td> <a href="{{route('dashboard.stores.show',$store->id)}}">{{$store->name}}</a> </td>
            <td>{{$store->department->name}}</td>{{--{{$store->parent?$store->parent->name:'-'}}--}}
            <td>{{$store->product_count}}</td>
            <td>{{$store->status}}</td>
            {{-- <td></td>
            <td></td> --}}

            {{-- @dd(Auth::user()->hasAbility('store.update')) --}}
            <td>@can('update',$store)<a href="{{route('dashboard.stores.edit',$store->id)}}"class='btn btn-sm btn-outline-info'>edit</a>@endcan</td>
            <td>



                @if(Auth::user()->can('delete',$store))
               <form action="{{route('dashboard.stores.destroy',$store->id)}}" method="POST">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">delete</button>
                </form>
                @endif
            </td>


            @empty
            <td colspan="8">there is not store</td>

        </tr>
        @endforelse
    </tbody>
</table>
{{$stores->withQueryString()->links();}}
@endsection
