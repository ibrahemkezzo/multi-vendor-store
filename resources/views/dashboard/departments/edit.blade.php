@extends('layouts.dashboards')

@section('title','Edit Departments')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Department </li>
<li class="breadcrumb-item active">Edit Department </li>
@endsection

@section('content')


<div class="content container-fluid col-lg-8">
    <form action="{{route('dashboard.departments.update',$department->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('dashboard.departments._form')
    </form>
</div>

@endsection
