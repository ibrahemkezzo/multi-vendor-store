<x-front-layout>
    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="container">
            <x-form.alert type='info'/>
            <div class="row">
                <div class="col-lg-8 col-12 custom-padding-right">
                    <div class="slider-head">
                        <!-- Start Hero Slider -->
                        <div class="hero-slider">
                            <!-- Start Single Slider -->
                            @foreach ($featureds as $featured )
                            <div class="single-slider"
                                style="background-image: url('assets/images/hero/slider-bg1.jpg');">
                                <div class="container row align">
                                    <div class="product-image col-lg-4 col-md-6 col-12"></div>
                                    <div class="product-image col-lg-4 col-md-5 col-12"></div>
                                <div class="product-image col-lg-4 col-md-7 col-12 ">
                                    <img height="400" src="{{ $featured->image }}" alt="#">
                                </div>
                                </div>
                                <div class="content">
                                    <h2><span>No restocking fee ({{($featured->compare_price - $featured->price)}} savings)</span>
                                        {{$featured->name}}
                                    </h2>
                                    <p>{{$featured->description}}</p>
                                    <h3><span>Now Only</span> {{$featured->price}}</h3>
                                    <div class="button">
                                        <a href="{{route('product.show',$featured->slug)}}" class="btn">Shop Now</a>
                                    </div>
                                </div>

                            </div>

                            @endforeach
                            <!-- End Single Slider -->
                            <!-- Start Single Slider -->
                            {{-- <div class="single-slider"
                                style="background-image: url(assets/images/hero/slider-bg2.jpg);">
                                <div class="content">
                                    <h2><span>Big Sale Offer</span>
                                        Get the Best Deal on CCTV Camera
                                    </h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.</p>
                                    <h3><span>Combo Only:</span> $590.00</h3>
                                    <div class="button">
                                        <a href="product-grids.html" class="btn">Shop Now</a>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- End Single Slider -->
                        </div>
                        <!-- End Hero Slider -->
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-12 md-custom-padding">
                            <!-- Start Small Banner -->
                            <div class="hero-small-banner"
                                style="background-image: url('assets/images/hero/slider-bnr.jpg');">
                                <div class="container row align">
                                    <div class="product-image col-lg-4 col-md-6 col-12"></div>
                                    <div class="product-image col-lg-4 col-md-5 col-12"></div>
                                <div class="product-image col-lg-4 col-md-7 col-12 ">
                                    <img height="200" src="{{ $TopRate[0]->image }}" alt="#">
                                </div>
                                </div>
                                <div class="content">
                                    <h2>
                                        <span>New line required</span>
                                        {{$TopRate[0]->name}}
                                    </h2>
                                    <h3>{{$TopRate[0]->price}}</h3>

                                </div>
                            </div>
                            <!-- End Small Banner -->
                        </div>
                        <div class="col-lg-12 col-md-6 col-12">
                            <!-- Start Small Banner -->
                            <div class="hero-small-banner style2">
                                <div class="content">
                                    <h2>Weekly Sale!</h2>
                                    <p>Saving up to 50% off all online store items this week.</p>
                                    <div class="button">
                                        <a class="btn" href="{{route('all-products')}}">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Start Small Banner -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero Area -->
    <!-- starrt department Area -->
    <section class="featured-categories section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Featured Categories</h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                            suffered alteration in some form.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($departments as $department)
                <x-front.department :department="$department"/>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End department Area -->


    <!-- Start Trending Product Area -->
    <section class="trending-product section" style="margin-top: 12px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Trending Product</h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                            suffered alteration in some form.</p>
                    </div>
                </div>
            </div>
            <div class="row">

                @foreach ($products as $product)
                <x-front.product :product="$product"/>
                @endforeach

                {{-- {{ dd(555)}} --}}
            </div>
        </div>
    </section>
    <!-- End Trending Product Area -->

    {{-- <!-- Start Call Action Area -->
    <section class="call-action section">
        <div class="container">
            <div class="row ">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="inner">
                        <div class="content">
                            <h2 class="wow fadeInUp" data-wow-delay=".4s">Currently You are using free<br>
                                Lite version of ShopGrids</h2>
                            <p class="wow fadeInUp" data-wow-delay=".6s">Please, purchase full version of the template
                                to get all pages,<br> features and commercial license.</p>
                            <div class="button wow fadeInUp" data-wow-delay=".8s">
                                <a href="javascript:void(0)" class="btn">Purchase Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Call Action Area --> --}}

    <!-- Start Banner Area -->
    <section class="banner section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="single-banner" style="background-image:url('assets/images/banner/banner-1-bg.jpg')">
                        <div class="row align">
                            <div class="content  col-8">

                                <h2>{{$TopRate[1]->name}}</h2>
                                <p>{{$TopRate[1]->description}} </p>
                                <div class="button">
                                    <a href="{{route('product.show',$TopRate[1]->slug)}}" class="btn">View Details</a>
                                </div>
                            </div>
                            <div class="product-image col-4">
                                <img height="300" src="{{ $TopRate[1]->image }}" alt="#">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12 ">
                    <div class="single-banner" style="background-image:url('assets/images/banner/banner-1-bg.jpg')">
                        <div class="row align">
                            <div class="content  col-8">

                                <h2>{{$TopRate[2]->name}}</h2>
                                <p>{{$TopRate[2]->description}} </p>
                                <div class="button">
                                    <a href="{{route('product.show',$TopRate[2]->slug)}}" class="btn">View Details</a>
                                </div>
                            </div>
                            <div class="product-image col-4">
                                <img height="300" src="{{ $TopRate[2]->image }}" alt="#">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!-- Start Shipping Info -->
    <section class="shipping-info">
        <div class="container">
            <ul>
                <!-- Free Shipping -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-delivery"></i>
                    </div>
                    <div class="media-body">
                        <h5>Free Shipping</h5>
                        <span>On order over $99</span>
                    </div>
                </li>
                <!-- Money Return -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-support"></i>
                    </div>
                    <div class="media-body">
                        <h5>24/7 Support.</h5>
                        <span>Live Chat Or Call.</span>
                    </div>
                </li>
                <!-- Support 24/7 -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-credit-cards"></i>
                    </div>
                    <div class="media-body">
                        <h5>Online Payment.</h5>
                        <span>Secure Payment Services.</span>
                    </div>
                </li>
                <!-- Safe Payment -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-reload"></i>
                    </div>
                    <div class="media-body">
                        <h5>Easy Return.</h5>
                        <span>Hassle Free Shopping.</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <!-- End Shipping Info -->
    @push('script')
    <script type="text/javascript">
        //========= Hero Slider
        tns({
            container: '.hero-slider',
            slideBy: 'page',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 0,
            items: 1,
            nav: false,
            controls: true,
            controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
        });

        //======== Brand Slider
        tns({
            container: '.brands-logo-carousel',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 15,
            nav: false,
            controls: false,
            responsive: {
                0: {
                    items: 1,
                },
                540: {
                    items: 3,
                },
                768: {
                    items: 5,
                },
                992: {
                    items: 6,
                }
            }
        });
    </script>
    @endpush

</x-front-layout>
