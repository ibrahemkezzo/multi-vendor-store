@extends('layouts.dashboards')

@section('title','Stores')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Store / create</li>
@endsection

@section('content')


<div class="content container-fluid col-lg-8">
    <form action="{{route('dashboard.stores.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.stores._form',['button_key'=>'save'])

    </form>
</div>

@endsection
