@extends('layouts.dashboards')

@section('title','Create Product')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products / Create Product </li>
@endsection

@section('content')

<div class="content container-fluid col-lg-10">
    <form action="{{route('dashboard.products.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <x-form.input name='name' type='text' label='Name Product'/>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <x-form.selected label="Select The Store" name="store_id" :options="$stores" />
            </div>
            <div class="col-md-6">
                <x-form.selected label="Select The Category" name="category_id" :options="$categories" />
            </div>
        </div>
        <div class="form-group">
            <x-form.input type="text" label="Description" name="description"  />
        </div>
        <div class="form-group">
            <x-form.input type="file" name="image" label="Image"/>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <x-form.input type='text' name='price' label='The Price'/>
            </div>
            <div class="col-md-6">
                <x-form.input type='text' name='quantity' label='Quantity'/>
            </div>
        </div>
        <div class="form-group">
            <x-form.input type="text" name="tags" label="tags" />
        </div>
        <div class="from-group">
            <x-form.checked name='status' :options="['active'=>'Active','draf'=>'Draf','archived'=>'Archived']" label='Status' />
        </div>
        <br>
        <button type="submit" class="btn btn-primary">create</button>
    </form>
</div>
@endsection
