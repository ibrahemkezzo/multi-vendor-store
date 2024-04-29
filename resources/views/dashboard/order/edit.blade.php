@extends('layouts.dashboards')

@section('title','Edit Oreder')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Order </li>
<li class="breadcrumb-item active">Edit Order </li>
@endsection

@section('content')


<div class="content container-fluid col-lg-8">
    <form action="{{route('dashboard.orders.update',$order->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('dashboard.order._form')
    </form>
</div>

@endsection
