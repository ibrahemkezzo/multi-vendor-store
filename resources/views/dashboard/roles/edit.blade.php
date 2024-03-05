@extends('layouts.dashboards')

@section('title','Edit Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Role </li>
<li class="breadcrumb-item active">Edit Role </li>
@endsection

@section('content')


<div class="content container-fluid col-lg-8">
    <form action="{{route('dashboard.roles.update',$role->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('dashboard.roles._form')
    </form>
</div>

@endsection
