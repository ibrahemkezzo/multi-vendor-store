<x-front-layout title="{{ __('Cart') }}">

    <x-slot name="breadcrumb">
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">{{ __('Cart') }}</h1>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('front.home') }}"><i class="lni lni-home"></i> {{ __('Home') }}</a></li>
                            <li><a href="{{ route('product.index') }}">{{ __('Shop') }}</a></li>
                            <li>{{ __('My Orders') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="cart-list-head">
                <!-- Cart List Title -->
                <div class="cart-list-title">
                    <div class="row">
                        <div class="col-6 col-md-2 col-lg-1">
                            <p>{{ __('Number') }}</p>
                        </div>
                        <div class="col-6 col-md-3 col-lg-4">
                            <p>{{ __('Store Name') }}</p>
                        </div>
                        <div class="col-6 col-md-2 col-lg-2">
                            <p>{{ __('Status') }}</p>
                        </div>
                        <div class="col-6 col-md-2 col-lg-1">
                            <p>{{ __('Product Count') }}</p>
                        </div>
                        <div class="col-6 col-md-3 col-lg-2">
                            <p>{{ __('Total Cost') }}</p>
                        </div>
                        <div class="col-6 col-md-12 col-lg-2">
                            <p>{{ __('Actions') }}</p>
                        </div>
                    </div>
                </div>
                <!-- End Cart List Title -->

                @foreach ($orders as $order)
                    <!-- Cart Single List -->
                    <div class="cart-single-list">
                        <div class="row align-items-center">
                            <div class="col-6 col-md-2 col-lg-1">
                                <a href="{{ route('orders.show', $order->id) }}">
                                    <p class="text-truncate">{{ $order->number }}</p>
                                </a>
                            </div>
                            <div class="col-6 col-md-3 col-lg-4">
                                <h5 class="product-name">
                                    <a href="{{ route('shop.stores.show', $order->store_id) }}" class="text-truncate">
                                        {{ $order->store->name }}
                                    </a>
                                </h5>
                            </div>
                            <div class="col-6 col-md-2 col-lg-2">
                                <p class="text-truncate">{{ $order->payment_status }}</p>
                            </div>
                            <div class="col-6 col-md-2 col-lg-1">
                                <p>{{ $order->products->count() }}</p>
                            </div>
                            <div class="col-6 col-md-3 col-lg-2">
                                <p>{{ App\Helpers\Currency::formate($order->total, 'USD') }}</p>
                            </div>
                            <div class="col-6 col-md-12 col-lg-2 d-flex flex-row gap-2 align-items-center">
                                <a class="btn btn-sm btn-secondary show-order" href="{{ route('orders.show', $order->id) }}">
                                    {{ __('Show') }}
                                </a>
                                @if ($order->payment_status == 'pending')
                                    <a class="btn btn-sm btn-primary" href="{{ route('payment.index', $order->id) }}">
                                        {{ __('Pay') }}
                                    </a>
                                @endif
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('{{ __('Are you sure you want to delete this order?') }}')">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Single List -->
                @endforeach
            </div>
            {{ $orders->withQueryString()->links('pagination::tailwind') }}
        </div>
    </div>
@push('style')
<style>
    .cart-single-list a:hover {
        color: white;
    }
    .cart-single-list .product-name {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cart-single-list p {
        margin-bottom: 0;
    }
    .cart-list-title p {
        font-size: 0.9rem;
        font-weight: bold;
    }
    .cart-single-list .btn {
        padding: 6px 12px;
        font-size: 0.85rem;
        line-height: 1.5;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 60px;
    }
    .cart-single-list .d-flex {
        gap: 8px;
    }
    @media (max-width: 767px) {
        .cart-single-list .row {
            flex-wrap: wrap;
        }
        .cart-single-list .col-6 {
            margin-bottom: 8px;
        }
        .cart-list-title p {
            font-size: 0.8rem;
        }
        .cart-single-list .btn {
            padding: 5px 8px;
            font-size: 0.75rem;
            height: 28px;
            min-width: 50px;
        }
        .cart-single-list .d-flex {
            gap: 5px;
        }
    }
    @media (min-width: 768px) and (max-width: 991px) {
        .cart-single-list .btn {
            padding: 5px 10px;
            font-size: 0.8rem;
            height: 30px;
            min-width: 55px;
        }
        .cart-single-list .d-flex {
            gap: 6px;
        }
    }
</style>
@endpush
</x-front-layout>
