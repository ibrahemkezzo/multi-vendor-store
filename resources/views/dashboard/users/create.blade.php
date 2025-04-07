@extends('layouts.dashboards')

@section('title','Categories')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">User / Create</li>
@endsection

@section('content')


<div class="content container-fluid col-lg-8">
    <form action="{{route('dashboard.users.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.users._form')

        <div class="form-group">
            <x-form.input type='password' name='password' label='Password' />
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-outline-primary form-control"> create</button>
        </div>
    </form>
</div>

@endsection
