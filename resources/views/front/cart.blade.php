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
                            <li>Cart</li>
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

                        </div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <p>Product Name</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Quantity</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Subtotal</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>Discount</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <p>Remove</p>
                        </div>
                    </div>
                </div>
                <!-- End Cart List Title -->


                @foreach ($cart->get() as $item)
                    <!-- Cart Single List list -->
                    <div class="cart-single-list">
                        <div class="row align-items-center">
                            <div class="col-lg-1 col-md-1 col-12">
                                <a href="product-details.html"><img src="{{ $item->product->image }}"
                                        alt="#"></a>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12">
                                <h5 class="product-name"><a href="{{ route('product.show', $item->product->slug) }}">
                                        {{ $item->product->name }}</a></h5>
                                <p class="product-des">
                                    {{-- <span><em>Memory:</em> 256 GB</span>
                                <span><em>Color:</em> Space Gray</span> --}}
                                    <span>{{ $item->product->description }}</span>
                                </p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="count-input">
                                        <input type ="number" name="quantity" class="form-control"
                                            value="{{ $item->quantity }}" />
                                        @if ($errors->has('quantity'))
                                            <div class="text-danger">{{ $errors->first() }}</div>
                                        @endif
                                    </div>
                                    <button class="btn-sm btn-light" type="submit">update</button>
                                </form>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>{{ App\Helpers\Currency::formate($item->product->price * $item->quantity) }}</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12">
                                <p>—</p>
                            </div>
                            <div class="col-lg-1 col-md-2 col-12">
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="remove-item"><i class="lni lni-close"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Single List list -->
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
                                        <form action="#" target="_blank">
                                            <input name="Coupon" placeholder="Enter Your Coupon">
                                            <br><br>
                                            <div class="button">
                                                <button class="btn">Apply Coupon</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="right">
                                    <ul>
                                        <li>Cart
                                            Subtotal<span>{{ App\Helpers\Currency::formate($cart->total(), 'USD') }}</span>
                                        </li>
                                        <li>Shipping<span>Free</span></li>
                                        <li>You Save<span>$29.00</span></li>
                                        <li class="last">You
                                            Pay<span>{{ App\Helpers\Currency::formate($cart->total(), 'USD') }}</span>
                                        </li>
                                    </ul>
                                    <div class="button">
                                        <a href="{{ route('checkout') }}" class="btn">Checkout</a>
                                        <a href="product-grids.html" class="btn btn-alt">Continue shopping</a>
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
    <!--/ End Shopping Cart -->







</x-front-layout>
