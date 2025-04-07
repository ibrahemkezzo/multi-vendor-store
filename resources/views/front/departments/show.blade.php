<x-front-layout title="product-department">
    <x-slot name='breadcrumb'>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">The Store</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('front.home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li>{{$department->name}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <section class="trending-product section" style="margin-top: 12px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>{{$department->name}}</h2>
                        <p>{{$department->description}}</p>
                    </div>
                </div>
            </div>
            <div class="row">

                @foreach ($products as $product)
                <x-front.product :product="$product"/>
                @endforeach

            </div>
        </div>
    </section>
</x-front-layout>
