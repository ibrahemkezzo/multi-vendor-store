@extends('layouts.dashboards')

@section('title','Edit Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Category </li>
<li class="breadcrumb-item active">Edit Category </li>
@endsection

@section('content')


<div class="content container-fluid col-lg-8">
    <form action="{{route('dashboard.categories.update',$category->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('dashboard.categories._form')
    </form>
</div>

@endsection
