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
        <div class="row">
        @include('dashboard.admins._form')
         <div class="form-group col-md-3 mt-4">
            <a href="{{route('dashboard.admins.index')}}" class="btn btn-outline-secondary form-control">{{'cancel'}}</a>
        </div>
        <div class="form-group col-md-3 mt-4">
            <button type="submit" class="btn btn-outline-primary form-control">{{'update'}}</button>
        </div>

        </div>
    </form>
</div>

@endsection
