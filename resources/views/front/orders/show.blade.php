<x-front-layout title="{{ __('Order Details') }}">

    <x-slot name="breadcrumb">
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">{{ __('Order') }} #{{ $order->number }}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('front.home') }}"><i class="lni lni-home"></i> {{ __('Home') }}</a></li>
                            <li><a href="{{ route('orders.index') }}">{{ __('My Orders') }}</a></li>
                            <li>{{ __('Order') }} #{{ $order->number }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </x-slot>

    <!-- Order Details -->
    <div class="shopping-cart section">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="cart-list-head">
                <!-- Order Items Title -->
                <div class="cart-list-title">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-12"></div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <p>{{ __('Product Name') }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ __('Quantity') }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ __('Subtotal') }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ __('Discount') }}</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <p>{{ __('Remove') }}</p>
                        </div>
                    </div>
                </div>
                <!-- End Order Items Title -->

                @foreach ($order->products as $item)
                    <!-- Order Item -->
                    <div class="cart-single-list">
                        <div class="row align-items-center">
                            <div class="col-lg-1 col-md-1 col-12">
                                <a href="{{ route('product.show', $item->slug) }}">
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="#" height="170rem" width="200rem">
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <h5 class="product-name">
                                    <a href="{{ route('product.show', $item->slug) }}">{{ $item->name }}</a>
                                </h5>
                                <p class="product-des">
                                    <span>{{ $item->description }}</span>
                                </p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <form action="{{ route('orders.item.update', [$order->id, $item->order_item->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="count-input">
                                        <input type="number" name="quantity" class="form-control" value="{{ $item->order_item->quantity }}" min="1" max="100" />
                                        @error('quantity')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button class="btn-sm btn-light" type="submit">{{ __('Update') }}</button>
                                </form>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>{{ App\Helpers\Currency::formate($item->order_item->price * $item->order_item->quantity, 'USD') }}</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>—</p> <!-- Assuming no per-item discount -->
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <form action="{{ route('orders.item.destroy', [$order->id, $item->order_item->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-item"><i class="lni lni-close"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Order Item -->
                @endforeach

            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <ul>
                                            <li>{{ __('Order') }} <span>#{{ $order->number }}</span></li>
                                            <li>{{ __('Status') }}:<span>{{ $order->status }}</span></li>
                                            <li>{{ __('Shipping') }}:<span>{{ App\Helpers\Currency::formate($order->shipping, 'USD') }}</span></li>
                                            <li>{{ __('Payment Status') }}: <span>{{ $order->payment_status }}</span></li>
                                        </ul>
                                        <div class="button mt-4">
                                            <a href="{{ route('order.payment.create', $order->id) }}" class="btn pay-order">{{ __('Pay Order') }}</a>
                                        </div>
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger delete-order" onclick="return confirm('{{ __('Are you sure you want to delete this order?') }}')">{{ __('Delete Order') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="right">
                                    <ul>
                                        <li>{{ __('Subtotal') }}<span>{{ App\Helpers\Currency::formate($order->total - $order->discount - $order->tax - $order->shipping, 'USD') }}</span></li>
                                        <li>{{ __('Discount') }}<span>-{{ App\Helpers\Currency::formate($order->discount, 'USD') }}</span></li>
                                        <li>{{ __('Shipping') }}<span>{{ App\Helpers\Currency::formate($order->shipping, 'USD') }}</span></li>
                                        <li>{{ __('Tax') }}<span>{{ App\Helpers\Currency::formate($order->tax, 'USD') }}</span></li>
                                        <li class="last">{{ __('Total') }}<span>{{ App\Helpers\Currency::formate($order->total, 'USD') }}</span></li>
                                    </ul>
                                    <div class="button">
                                        <a href="{{ route('orders.index') }}" class="btn">{{ __('Back to Orders') }}</a>
                                        <a href="{{ route('front.home') }}" class="btn btn-alt">{{ __('Continue Shopping') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Order Details -->
@push('style')
<style>
.pay-order {
    width: 100%;
    margin-bottom: 8px;
    text-align: center;
    padding: 12px 20px;
}
.delete-order {
    width: 100%;
    margin-bottom: 8px;
    text-align: center;
    padding: 12px 20px;
}
</style>
@endpush
</x-front-layout>
