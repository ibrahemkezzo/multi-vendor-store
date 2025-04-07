@extends('layouts.dashboards')

@section('title','Departments')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Department / Create</li>
@endsection

@section('content')


<div class="content container-fluid col-lg-8">
    <form action="{{route('dashboard.departments.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.departments._form',['button_key'=>'save'])

    </form>
</div>

@endsection
