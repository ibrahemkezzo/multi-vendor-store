@extends('layouts.dashboards')

@section('title', 'Edit Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">User </li>
    <li class="breadcrumb-item active">Edit User </li>
@endsection

@section('content')


    <div class="content container-fluid col-lg-8">
        <form action="{{ route('dashboard.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')


            @include('dashboard.users._form')


            <div class="form-group">
                <button type="submit" class="btn btn-outline-primary form-control"> update</button>
            </div>

        </form>
    </div>

@endsection
