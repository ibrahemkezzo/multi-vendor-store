@extends('layouts.dashboards')

@section('title', __('Edit Order'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.orders.index') }}">{{ __('Orders') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit Order') }}</li>
@endsection

@section('content')
    <div class="content container-fluid col-lg-8">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dashboard.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('dashboard.order._form')
        </form>

        <a href="{{ route('dashboard.orders.index') }}" class="btn btn-outline-secondary mt-3">{{ __('Back to Orders') }}</a>
    </div>
@endsection
