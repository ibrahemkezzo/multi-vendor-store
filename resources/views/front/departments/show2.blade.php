<x-front-layout title='shop-list'>

    <x-slot name='breadcrumb'>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">{{ $department->name }}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('front.home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li>{{ $department->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Include Bootstrap JS for dropdown functionality -->
    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endpush

    <section class="product-grids section">
        <div class="container">
            <div class="row">
                <!-- Mobile Filter Dropdown -->
                <div class="col-12 d-block d-md-none mb-3">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle w-100" type="button" id="mobileFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter Departments & Categories
                        </button>
                        <div class="dropdown-menu w-100" aria-labelledby="mobileFilterDropdown">
                            <!-- Departments -->
                            <div class="single-widget">
                                <h3>All Departments</h3>
                                <ul class="list-unstyled">
                                    @foreach ($departments as $department)
                                        <li>
                                            <a href="{{ route('front.department.show', $department->id) }}">{{ $department->name }}</a>
                                            <span>(1138)</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- Categories -->
                            <div class="single-widget">
                                <h3>All Categories</h3>
                                <ul class="list-unstyled">
                                    @foreach ($categories as $category)
                                        <li>
                                            <a href="{{ route('filter.category', $category->id) }}">{{ $category->name }}</a>
                                            <span>{{$category->products_count}}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-12 d-none d-md-block">
                    <!-- Start Product Sidebar -->
                    <div class="product-sidebar">
                        <!-- Start Single Widget -->
                        <div class="single-widget search">
                            <h3>Search Product</h3>
                            <form action="#">
                                <input type="text" placeholder="Search Here...">
                                <button type="submit"><i class="lni lni-search-alt"></i></button>
                            </form>
                        </div>
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        <div class="single-widget">
                            <h3>All Departments</h3>
                            <ul class="list">
                                @foreach ($departments as $department)
                                    <li>
                                        <a href="{{ route('front.department.show', $department->id) }}">{{ $department->name }}</a>
                                        <span>({{$department->products_count}})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        <div class="single-widget">
                            <h3>All Categories</h3>
                            <ul class="list">
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ route('filter.category', $category->id) }}">{{ $category->name }}</a>
                                        <span>({{$category->products_count}})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <!-- End Product Sidebar -->
                </div>
                <div class="col-lg-9 col-12">
                    <div class="product-grids-head">
                        <div class="product-grid-topbar">
                            <div class="row align-items-center">
                                <div class="col-lg-7 col-md-8 col-12">
                                    <div class="product-sorting">
                                        {{ $products->withQueryString()->links('pagination::tailwind') }}
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-4 col-12">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-grid" type="button" role="tab"
                                                aria-controls="nav-grid" aria-selected="true"><i
                                                    class="lni lni-grid-alt"></i></button>
                                            <button class="nav-link" id="nav-list-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-list" type="button" role="tab"
                                                aria-controls="nav-list" aria-selected="false"><i
                                                    class="lni lni-list"></i></button>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane show active fade" id="nav-grid" role="tabpanel"
                                aria-labelledby="nav-grid-tab">
                                <div class="row">
                                    @foreach ($products as $product)
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="single-product" style="height: 37em;">
                                                <div class="product-image">
                                                    <img src="{{ asset('storage/' . $product->image) }}" height="330em"
                                                        alt="#">
                                                    @if ($product->created_at->diffInDays(now()) <= 5)
                                                        <span class="new-tag">New</span>
                                                    @endif
                                                    <div class="button">
                                                        <a href="{{ route('product.show', $product->slug) }}"
                                                            class="btn"><i class="lni lni-cart"></i> Add to
                                                            Cart</a>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <span class="category">{{ $product->category->name }}</span>
                                                    <h4 class="title">
                                                        <a
                                                            href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                                    </h4>
                                                    <ul class="review">
                                                        <li><i class="lni lni-star-filled"></i></li>
                                                        <li><i class="lni lni-star-filled"></i></li>
                                                        <li><i class="lni lni-star-filled"></i></li>
                                                        <li><i class="lni lni-star-filled"></i></li>
                                                        <li><i class="lni lni-star-filled"></i></li>
                                                        <li><span>5.0 Review(s)</span></li>
                                                    </ul>
                                                    <div class="price">
                                                        <span>{{ currency::formate($product->price) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                                <div class="row">
                                    @foreach ($products as $product)
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="single-product">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-4 col-md-4 col-12">
                                                        <div class="product-image">
                                                            <img height="250em" src="{{ asset('storage/' . $product->image) }}"
                                                                alt="#">
                                                            <span class="sale-tag">-25%</span>
                                                            <div class="button">
                                                                <a href="{{ route('product.show', $product->slug) }}"
                                                                    class="btn"><i class="lni lni-cart"></i> Add to
                                                                    Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-12">
                                                        <div class="product-info">
                                                            <span
                                                                class="category">{{ $product->category->name }}</span>
                                                            <h4 class="title">
                                                                <a
                                                                    href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                                            </h4>
                                                            <ul class="review">
                                                                <li><i class="lni lni-star-filled"></i></li>
                                                                <li><i class="lni lni-star-filled"></i></li>
                                                                <li><i class="lni lni-star-filled"></i></li>
                                                                <li><i class="lni lni-star-filled"></i></li>
                                                                <li><i class="lni lni-star-filled"></i></li>
                                                                <li><span>5.0 Review(s)</span></li>
                                                            </ul>
                                                            <div class="price">
                                                                <span>{{ currency::formate($product->price) }}</span>
                                                                <span
                                                                    class="discount-price">{{ $product->compare_price }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@push('style')

    <style>
        @media (max-width: 767px) {
            .product-sidebar {
                display: none !important;
            }
            .dropdown-menu {
                max-height: 300px;
                overflow-y: auto;
                padding: 15px;
            }
            .single-widget {
                margin-bottom: 20px;
            }
            .single-widget h3 {
                font-size: 1.2rem;
                margin-bottom: 10px;
            }
            .single-widget ul.list-unstyled li {
                display: flex;
                justify-content: space-between;
                padding: 5px 0;
            }
        }
    </style>
@endpush
</x-front-layout>
