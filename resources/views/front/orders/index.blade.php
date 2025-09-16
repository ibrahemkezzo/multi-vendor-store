<x-front-layout title='cart'>

    <x-slot name='breadcrumb'>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Cart</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('front.home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="{{ route('product.index') }}">Shop</a></li>
                            <li>My Orders</li>
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
                        <div class="col-lg-1 col-md-1 col-12">
                            <p>Number</p>
                        </div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <p>Store Name</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Status</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <p>Acount Product</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Total Cost</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Actions</p>
                        </div>
                    </div>
                </div>
                <!-- End Cart List Title -->


                @foreach ($orders as $order)
                    <!-- Cart Single List list -->
                    <div class="cart-single-list">
                        <div class="row align-items-center">
                            <div class="col-lg-1 col-md-1 col-12">
                                <a href="{{ route('orders.show', $order->id) }}">
                                    <p>
                                        {{$order->number}}
                                    </p>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <h5 class="product-name"><a href="{{ route('shop.stores.show', $order->store_id) }}">
                                        {{ $order->store->name }}</a></h5>
                                {{-- <p class="product-des">
                                    <span><em>Memory:</em> 256 GB</span>
                                    <span><em>Color:</em> Space Gray</span>
                                    <span>{{ $order->product->description }}</span>
                                </p> --}}
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                              <p>
                                {{$order->status}}
                              </p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <p>
                                    {{$order->products->count()}}
                                </p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>{{ App\Helpers\Currency::formate($order->total) }}</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12 row">

                                <div class="col-lg-6 col-md-6 col-12">
                                    <a class="btn btn-sm btn-secondary" href="{{route('orders.show',$order->id)}}"> show order </a>
                                </div>
                                 @if ($order->payment_status == 'pending')
                                <div class="col-lg-6 col-md-6 col-12">
                                    <a class="btn btn-sm btn-primary" href="{{route('order.payment.create',$order->id)}}"> pay order </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- End Single List list -->
                @endforeach
            </div>
            {{$orders->withQueryString()->links('pagination::tailwind')}}
        </div>
    </div>


</x-front-layout>
