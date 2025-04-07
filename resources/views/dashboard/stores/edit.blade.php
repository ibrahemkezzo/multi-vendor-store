@extends('layouts.dashboards')

@section('title','Edit Stores')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Store </li>
<li class="breadcrumb-item active">Edit Store </li>
@endsection

@section('content')


<div class="content container-fluid col-lg-8">
    <form action="{{route('dashboard.stores.update',$store->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('dashboard.stores._form')
    </form>
</div>

@endsection
