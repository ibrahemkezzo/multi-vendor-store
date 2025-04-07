<div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-6 col-12">
                <div class="nav-inner">
                    <!-- Start Mega Category Menu -->
                    <div class="mega-category-menu">
                        <span class="cat-button"><i class="lni lni-menu"></i>{{ __('All Categories') }}</span>
                        <ul class="sub-category">

                            @foreach ($categories as $category)
                                @if ($category->parent_id == null)
                                    <li><a href="{{route('filter.category',$category->id)}}">{{ $category->name }}
                                            @if (count($category->childrens) > 0)
                                                <i class="lni lni-chevron-right"></i>
                                        </a>
                                        <ul class="inner-sub-category">
                                            @foreach ($category->childrens as $children)
                                                <li><a href="#">{{ $children->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    @else
                                        </a>
                                @endif
                                </li>
                            @endif
                            @endforeach
                            {{-- <li><a href="product-grids.html">Electronics <i class="lni lni-chevron-right"></i></a>
                                <ul class="inner-sub-category">
                                    <li><a href="product-grids.html">Digital Cameras</a></li>
                                </ul>
                            </li> --}}

                        </ul>
                    </div>
                    <!-- End Mega Category Menu -->
                    <!-- Start Navbar -->
                    <nav class="navbar navbar-expand-lg">
                        <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a href="{{ route('front.home') }}"
                                        aria-label="Toggle navigation">{{ __('Home') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse"
                                        data-bs-target="#submenu-1-2" aria-controls="navbarSupportedContent"
                                        aria-expanded="false" aria-label="Toggle navigation">{{ __('Pages') }}</a>
                                    <ul class="sub-menu collapse" id="submenu-1-2">
                                        <li class="nav-item"><a href="about-us.html">{{ __('Home') }}</a></li>
                                        <li class="nav-item"><a
                                                href="{{ route('shop-stores') }}">{{ __('Stores') }}</a></li>
                                        <li class="nav-item"><a href="{{route('contact-us')}}">{{ __('Contact US') }}</a></li>
                                        {{-- <li class="nav-item"><a href="{{route('about-as')}}">{{ __('About As') }}</a></li> --}}
                                        @auth('web')
                                        @else
                                            <li class="nav-item"><a href="{{ route('login') }}">{{ __('Login') }}</a>
                                            </li>
                                            <li class="nav-item"><a
                                                    href="{{ route('register') }}">{{ __('Register') }}</a></li>
                                        @endauth
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="dd-menu active collapsed" href="javascript:void(0)"
                                        data-bs-toggle="collapse" data-bs-target="#submenu-1-3"
                                        aria-controls="navbarSupportedContent" aria-expanded="false"
                                        aria-label="Toggle navigation">{{ __('Shop') }}</a>
                                        <ul class="sub-menu collapse" id="submenu-1-3">
                                            <li class="nav-item {{ Request::routeIs('all-products') ? 'active' : '' }}">
                                                <a href="{{ route('all-products') }}">All Products</a>
                                            </li>
                                            <li class="nav-item {{ Request::routeIs('shop-stores') ? 'active' : '' }}">
                                                <a href="{{ route('shop-stores') }}">Stores List</a>
                                            </li>
                                            <li class="nav-item {{ Request::routeIs('categories.index') ? 'active' : '' }}">
                                                <a href="{{ route('front.department.index') }}">Departments</a>
                                            </li>
                                            <li class="nav-item {{ Request::routeIs('cart.index') ? 'active' : '' }}">
                                                <a href="{{ route('cart.index') }}">{{ __('Cart') }}</a>
                                            </li>
                                            <li class="nav-item {{ Request::routeIs('checkout') ? 'active' : '' }}">
                                                <a href="{{ route('checkout') }}">{{ __('Checkout') }}</a>
                                            </li>
                                        </ul>

                                </li>
                                
                                <li class="nav-item">
                                    <a href="contact.html" aria-label="Toggle navigation">{{ __('Contact Us') }}</a>
                                </li>
                            </ul>
                        </div> <!-- navbar collapse -->
                    </nav>
                    <!-- End Navbar -->
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <!-- Start Nav Social -->
                <div class="nav-social">
                    <h5 class="title">{{ __('Follow Us') }}:</h5>
                    <ul>
                        <li>
                            <a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><i class="lni lni-instagram"></i></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><i class="lni lni-skype"></i></a>
                        </li>
                    </ul>
                </div>
                <!-- End Nav Social -->
            </div>
        </div>
    </div>
</div>
