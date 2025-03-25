@extends('layouts.dashboards')

@section('title','Edit Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Admin </li>
<li class="breadcrumb-item active">Edit Admin </li>
@endsection

@section('content')


<div class="content container-fluid col-lg-8">
    <form action="{{route('dashboard.admins.update',$admin->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('dashboard.admins._form')
    </form>
</div>

@endsection
