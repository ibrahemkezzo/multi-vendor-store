@extends('layouts.dashboards')

@section('title','Edit Product')

@section('breadcrumb')
@parent

<li class="breadcrumb-item active">Products / Edit Product </li>
@endsection

@section('content')

<x-form.alert type='success'/>

<div class="content container-fluid col-lg-10">
    <form action="{{route('dashboard.products.update',$product->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-row">
            <div class="col-md-6">
                <x-form.input type='text' name='name' label='product name' :value="$product->name" />
                    {{-- <input type='' /> --}}
            </div>
             <div class="col-md-6">
                <x-form.selected label="Select The Category" name="category_id" :options="$categories" />
            </div>
        </div>
        <div class="    ">
                 <x-form.input type='text' name='description' label='discripton' :value="$product->description"/>
        </div>
        <div class="form-group">
            <x-form.input type='file' label="image" name='image' />
            @if ($product->image)
            <img src="{{asset('storage/'.$product->image)}}" alt="" height="200px" width="250px" >
            @endif
        </div>
        <div class="form-row">
            <div class="col-md-4">
                <x-form.input type='number' name='price' label='price' :value="$product->price"/>
            </div>
            <div class="col-md-4">
                <x-form.input type='number' name='compare_price' label='compare_price' :value="$product->compare_price" />
            </div>
            <div class="col-md-4">
                <x-form.input type='number' name='quantity' label='quantity' :value="$product->quantity" />
            </div>

        </div>
        <div class="form-group">
            <x-form.input type="text" name="tags" label="tags" :value="$tags" />
        </div>
        <div class="form-group">
            <x-form.checked label='status' name='status' :options="['active'=>'Active',
            'draf'=>'Draf',
            'archived'=>'Archived',]" :checked="$product->status" />
        </div>


        <br>
        <button type ='submit' class="btn btn-primary ">save</button>
    </form>
</div>

@endsection
