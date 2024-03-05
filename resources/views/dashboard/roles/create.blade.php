@extends('layouts.dashboards')

@section('title','Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Role / Create</li>
@endsection

@section('content')


<div class="content container-fluid col-lg-8">
    <form action="{{route('dashboard.roles.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.roles._form',['button_key'=>'save'])

    </form>
</div>

@endsection
