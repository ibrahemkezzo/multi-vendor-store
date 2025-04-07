@extends('layouts.dashboards')

@section('title','Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Category</li>
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

{{--
    <form action="{{URL::current()}}" method="GET" class="d-flex justify-content-between">
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
            <th>PARENT_NAME</th>
            <th>status</th>
            <th>deleted_at</th>
            <th colspan="2"><a href="{{route('dashboard.categories.index')}}" class="btn btn-sm btn-outline-primary">back</a></th>
        </tr>
    </thead>
    <tbody>

        @forelse ($categories as $category)
        <tr>


            <td>{{$category->id}}</td>
            <td><img src="/storage/{{$category->image}}"alt="" width="80px" ></td>
            <td>{{$category->name}}</td>
            <td>{{$category->parent_id}}</td>
            <td>{{$category->status}}</td>
            <td>{{$category->deleted_at}}</td>
            {{-- <td></td>
            <td></td> --}}
            <td><form action="{{route('dashboard.categories.restore',$category->id)}}" method="POST">
                @method('put')
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary">restore</button>
                </form></td>
            <td>
                <form action="{{route('dashboard.categories.force_delete',$category->id)}}" method="POST">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">delete</button>
                </form>
            </td>


            @empty
            <td colspan="7">there is not category</td>

        </tr>
        @endforelse
    </tbody>
</table>
{{$categories->withQueryString()->links();}}
@endsection
