@extends('layouts.dashboards')

@section('title', __('Order Details'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard.orders.index') }}">{{ __('Orders') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Order Details') }}</li>
@endsection

@section('content')
    <div class="container-fluid col-lg-10">
        <x-form.alert type="success" />
        <x-form.alert type="info" />

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Order Details') }} #{{ $order->number }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>{{ __('Order Number') }}:</strong> {{ $order->number }}</p>
                        <p><strong>{{ __('User') }}:</strong> {{ $order->user->name }}</p>
                        <p><strong>{{ __('Store') }}:</strong> {{ $order->store->name }}</p>
                        <p><strong>{{ __('Status') }}:</strong> {{ __($order->status) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>{{ __('Payment Status') }}:</strong> {{ __($order->payment_status) }}</p>
                        <p><strong>{{ __('Total') }}:</strong> {{ App\Helpers\Currency::formate($order->total, 'USD') }}</p>
                        <p><strong>{{ __('Discount') }}:</strong> {{ App\Helpers\Currency::formate($order->discount, 'USD') }}</p>
                        <p><strong>{{ __('Created At') }}:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                </div>

                <h4 class="mt-4">{{ __('Order Items') }}</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('Product Name') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Subtotal') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ App\Helpers\Currency::formate($item->price, 'USD') }}</td>
                                <td>{{ App\Helpers\Currency::formate($item->price * $item->quantity, 'USD') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">{{ __('No items in this order.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    @can('update', $order)
                        <a href="{{ route('dashboard.orders.edit', $order->id) }}" class="btn btn-sm btn-outline-info">{{ __('Edit') }}</a>
                    @endcan
                    @can('delete', $order)
                        <form action="{{ route('dashboard.orders.destroy', $order->id) }}" method="POST" class="d-inline">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('Are you sure you want to delete this order?') }}')">{{ __('Delete') }}</button>
                        </form>
                    @endcan
                    <a href="{{ route('dashboard.orders.index') }}" class="btn btn-sm btn-outline-secondary">{{ __('Back to Orders') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
