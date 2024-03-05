@extends('layouts.dashboards')

@section('title','Edit Profile')

@section('breadcrumb')
@parent

<li class="breadcrumb-item active">Edit profile </li>
@endsection

@section('content')

<x-form.alert type='success'/>

<div class="content container-fluid col-lg-10">
    <form action="{{route('dashboard.profile.update')}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-row">
            <div class="col-md-6">
                <x-form.input type='text' name='first_name' label='first name' :value="$user->profile->first_name"/>
            </div>
            <div class="col-md-6">
                <x-form.input type='text' name='last_name' label='last name' :value="$user->profile->last_name"/>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6">
                <x-form.input type='date' name='birthday' label='birthday' :value="$user->profile->birthday"/>
            </div>
            <div class="col-md-6">
                <x-form.checked  name='gender' label='Gender' :checked="$user->profile->gender" :options="['male'=>'Male','female'=>'female']"/>
            </div>

        </div>
        <div class="form-row">
            <div class="col-md-4">
                <x-form.input type='text' name='city' label='city' :value="$user->profile->city"/>
            </div>
            <div class="col-md-4">
                <x-form.input type='text' name='street_address' label='street_adress' :value="$user->profile->street_address"/>
            </div>
            <div class="col-md-4">
                <x-form.input type='text' name='state' label='state' :value="$user->profile->state"/>
            </div>

        </div>
        <div class="form-row">
            <div class="col-md-4">
                <x-form.input type='text' name='postal_code' label='postal_code' :value="$user->profile->postal_code"/>
            </div>
            <div class="col-md-4">
                <x-form.selected label='country' name='country' :selected="$user->profile->country" :options="$countries"/>
            </div>
            <div class="col-md-4">
                <x-form.selected label='local' name='locale' :selected="$user->profile->local" :options="$locales"/>
            </div>
        </div>
        <br>
        <button type ='submit' class="btn btn-primary ">save</button>
    </form>
</div>

@endsection
