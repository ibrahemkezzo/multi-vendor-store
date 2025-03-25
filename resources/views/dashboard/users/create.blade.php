@extends('layouts.dashboards')

@section('title','Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Admin / Create</li>
@endsection

@section('content')


<div class="content container-fluid col-lg-8">
    <form action="{{route('dashboard.admins.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <x-form.input type='email' name='email' label='email' />
        </div>
        <div class="form-group">
            <x-form.input type='text' name='username' label='user name' />
        </div>
        <div class="form-group">
            <x-form.input type='phone' name='phone_number' label='phone number' />
        </div>
        <div class="form-group">
            <x-form.input type='password' name='password' label='password' />
        </div>

        @include('dashboard.admins._form',['button_key'=>'save'])

    </form>
</div>

@endsection
