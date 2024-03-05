@extends('layouts.dashboards')

@section('title','Show Product')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products / Show </li>
@endsection

@section('content')
<h3>{{$product->name}}</h3>
<table class="table">
    <thead>
        <tr>
            <th> <b> The Store : </b></th>
            <th>{{$product->store->name}}</th>
        </tr>
        <tr>
            <th><b>In Category : </b></th>
            <th>{{$product->category->name}}</th>
        </tr>
        <tr>
            <th><b>The Tags:</b></th>
        </tr>
    </thead>
    <tbody>

        @foreach ($product->tags as $tag)
            <tr>
                <td>{{$tag->name}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
