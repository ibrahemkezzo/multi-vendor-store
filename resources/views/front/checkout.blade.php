<x-front-layout title="checkout">
<x-slot name="breadcrumb">
     <!-- Start Breadcrumbs -->
     <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">checkout</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="{{route('front.home')}}"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="{{route('cart.index')}}">Shop</a></li>
                        <li>checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
</x-slot>
<section class="checkout-wrapper section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="{{route('checkout')}}" method="post">
                    @csrf
                    <div class="checkout-steps-form-style-1">
                        <ul id="accordionExample">
                            <li>
                                <h6 class="title collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Your Personal Details </h6>
                                <section class="checkout-steps-form-content collapse" id="collapseThree" aria-labelledby="headingThree" data-bs-parent="#accordionExample" style="">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <label>User Name</label>
                                                <div class="row">
                                                    <div class="col-md-6 form-input form">
                                                        <input type="text" name="addr[billing][first_name]" placeholder="First Name">
                                                        <x-form.feedback name="addr[billing][first_name]"/>
                                                    </div>
                                                    <div class="col-md-6 form-input form">
                                                        <input type="text" name="addr[billing][last_name]" placeholder="last Name">
                                                        <x-form.feedback name="addr[billing][last_name]"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Email Address</label>
                                                <div class="form-input form">
                                                    <input type="text" name="addr[billing][email]" placeholder="Email Address">
                                                    <x-form.feedback name="addr[billing][email]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Phone Number</label>
                                                <div class="form-input form">
                                                    <input type="text" name="addr[billing][phone_number]" placeholder="Phone Number">
                                                    <x-form.feedback name="addr[billing][phone_number]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <label>Mailing Address</label>
                                                <div class="form-input form">
                                                    <input type="text" name="addr[billing][street_adress]" placeholder="Mailing Address">
                                                    <x-form.feedback name="addr[billing][street_adress]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>City</label>
                                                <div class="form-input form">
                                                    <input type="text" name="addr[billing][city]" placeholder="City">
                                                    <x-form.feedback name="addr[billing][city]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Post Code</label>
                                                <div class="form-input form">
                                                    <input type="text" name="addr[billing][postal_code]" placeholder="Post Code">
                                                    <x-form.feedback name="addr[billing][postal_code]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">

                                                <div class="select-items">
                                                    <x-form.checked name="addr[billing][status]" label="state"
                                                    :options="['billing'=>'billing','shipping'=>'shipping']"/>
                                                    <x-form.feedback name="addr[billing][status]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">

                                                <div class="form-input form">
                                                    <x-form.selected name="addr[billing][country]" label="Country" :options="$countries"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="single-checkbox checkbox-style-3">
                                                <input type="checkbox" id="checkbox-3">
                                                <label for="checkbox-3"><span></span></label>
                                                <p>My delivery and mailing addresses are the same.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-form button">
                                                <a class="btn collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">next
                                                    step</a>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </li>
                            <li>
                                <h6 class="title collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Shipping Address</h6>
                                <section class="checkout-steps-form-content collapse" id="collapseFour" aria-labelledby="headingFour" data-bs-parent="#accordionExample" style="">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <label>User Name</label>
                                                <div class="row">
                                                    <div class="col-md-6 form-input form">
                                                        <input type="text" name="addr[shipping][first_name]" placeholder="First Name">
                                                        <x-form.feedback name="addr[shipping][first_name]"/>
                                                    </div>
                                                    <div class="col-md-6 form-input form">
                                                        <input type="text" name="addr[shipping][last_name]" placeholder="last Name">
                                                        <x-form.feedback name="addr[shipping][last_name]"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Email Address</label>
                                                <div class="form-input form">
                                                    <input type="text" name="addr[shipping][email]" placeholder="Email Address">
                                                    <x-form.feedback name="addr[shipping][email]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Phone Number</label>
                                                <div class="form-input form">
                                                    <input type="text" name="addr[shipping][phone_number]" placeholder="Phone Number">
                                                    <x-form.feedback name="addr[shipping][phone_number]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <label>Mailing Address</label>
                                                <div class="form-input form">
                                                    <input type="text" name="addr[shipping][street_adress]" placeholder="Mailing Address">
                                                    <x-form.feedback name="addr[shipping][street_adress]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>City</label>
                                                <div class="form-input form">
                                                    <input type="text" name="addr[shipping][city]" placeholder="City">
                                                    <x-form.feedback name="addr[shipping][city]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Post Code</label>
                                                <div class="form-input form">
                                                    <input type="text" name="addr[shipping][postal_code]" placeholder="Post Code">
                                                    <x-form.feedback name="addr[shipping][postal_code]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Region/State</label>
                                                <div class="select-items">
                                                    <input type="text" name="addr[shipping][status]" placeholder="Post Code">
                                                    <x-form.feedback name="addr[shipping][status]"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Country</label>
                                                <div class="form-input form">
                                                    <x-form.selected name="addr[shipping][country]" label="Country" :options="$countries"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="checkout-payment-option">
                                                <h6 class="heading-6 font-weight-400 payment-title">Select Delivery
                                                    Option</h6>
                                                <div class="payment-option-wrapper">
                                                    <div class="single-payment-option">
                                                        <input type="radio" name="shipping" checked="" id="shipping-1">
                                                        <label for="shipping-1">
                                                            <img src="assets/images/shipping/shipping-1.png" alt="Sipping">
                                                            <p>Standerd Shipping</p>
                                                            <span class="price">$10.50</span>
                                                        </label>
                                                    </div>
                                                    <div class="single-payment-option">
                                                        <input type="radio" name="shipping" id="shipping-2">
                                                        <label for="shipping-2">
                                                            <img src="assets/images/shipping/shipping-2.png" alt="Sipping">
                                                            <p>Standerd Shipping</p>
                                                            <span class="price">$10.50</span>
                                                        </label>
                                                    </div>
                                                    <div class="single-payment-option">
                                                        <input type="radio" name="shipping" id="shipping-3">
                                                        <label for="shipping-3">
                                                            <img src="assets/images/shipping/shipping-3.png" alt="Sipping">
                                                            <p>Standerd Shipping</p>
                                                            <span class="price">$10.50</span>
                                                        </label>
                                                    </div>
                                                    <div class="single-payment-option">
                                                        <input type="radio" name="shipping" id="shipping-4">
                                                        <label for="shipping-4">
                                                            <img src="assets/images/shipping/shipping-4.png" alt="Sipping">
                                                            <p>Standerd Shipping</p>
                                                            <span class="price">$10.50</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="steps-form-btn button">
                                                <a  class="btn collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">previous</a>
                                                <button type="submit" href="javascript:void(0)" class="btn btn-alt">Save &amp; Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </li>
                            <li>
                                <h6 class="title collapsed" data-bs-toggle="collapse" data-bs-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">Payment Info</h6>
                                <section class="checkout-steps-form-content collapse" id="collapsefive" aria-labelledby="headingFive" data-bs-parent="#accordionExample" style="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="checkout-payment-form">

                                                <div class="single-form form-default button">
                                                    <button type="submit" id="submit" class="btn">pay now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
                <div class="checkout-sidebar">
                    <div class="checkout-sidebar-coupon">
                        <p>Appy Coupon to get discount!</p>
                        <form action="#">
                            <div class="single-form form-default">
                                <div class="form-input form">
                                    <input type="text" placeholder="Coupon Code">
                                </div>
                                <div class="button">
                                    <button class="btn">apply</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="checkout-sidebar-price-table mt-30">
                        <h5 class="title">Pricing Table</h5>

                        <div class="sub-total-price">
                            <div class="total-price">
                                <p class="value">Subotal Price:</p>
                                <p class="price">{{App\Helpers\Currency::formate($cart->total())}}</p>
                            </div>
                            <div class="total-price shipping">
                                <p class="value">Subotal Price:</p>
                                <p class="price">$10.50</p>
                            </div>
                            <div class="total-price discount">
                                <p class="value">Subotal Price:</p>
                                <p class="price">$10.00</p>
                            </div>
                        </div>

                        <div class="total-payable">
                            <div class="payable-price">
                                <p class="value">Subotal Price:</p>
                                <p class="price">{{App\Helpers\Currency::formate($cart->total())}}</p>
                            </div>
                        </div>
                        <div class="price-table-btn button">
                            <a href="javascript:void(0)" class="btn btn-alt">Checkout</a>
                        </div>
                    </div>
                    <div class="checkout-sidebar-banner mt-30">
                        <a href="product-grids.html">
                            <img src="assets/images/banner/banner.jpg" alt="#">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</x-front-layout>
