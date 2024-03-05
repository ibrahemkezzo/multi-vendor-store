@extends('layouts.dashboards')

@section('title','Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Category / create</li>
@endsection

@section('content')


<div class="content container-fluid col-lg-8">
    <form action="{{route('dashboard.product.import')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <x-form.input type='text' name='count' label='number product'/>
        </div>
    </form>
</div>

@endsection
