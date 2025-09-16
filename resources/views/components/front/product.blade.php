<div class="col-lg-3 col-md-6 col-12">


    <!-- Start Single Product -->
    <div class="single-product" style="height: 39em;">
        <div class="product-image">
            <img src="{{ asset('storage/' . $product->image) }}" height="330em" alt="#">
            @if ($product->sale_percent > 0)
                <span class="sale-tag">{{ $product->sale_percent }}%</span>
            @endif
            {{-- <span class="new-tag">New</span> --}}
            <div class="button">
                <a href="{{ route('product.show', $product->slug) }}" class="btn"><i class="lni lni-cart"></i> Add to
                    Cart</a>
            </div>
        </div>
        <div class="product-info">
            <span class="category">{{ $product->category->name }}</span>
            <h4 class="title">
                <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
            </h4>
            <ul class="review">
                <li><i class="lni lni-star-filled"></i></li>
                <li><i class="lni lni-star-filled"></i></li>
                <li><i class="lni lni-star-filled"></i></li>
                <li><i class="lni lni-star-filled"></i></li>
                <li><i class="lni lni-star"></i></li>
                <li><span>4.0 Review(s)</span></li>
            </ul>
            {{-- @dump($product->price) --}}
            <div class="price">
                <span style="text-decoration: none; color: #0167f3; font-size:500; font-wedth:23px; margin-left:15px;">{{ currency::formate($product->price) }}</span>
                <span class="discount-price">{{ $product->compare_price }}</span>
            </div>

        </div>
    </div>
    <!-- End Single Product -->
</div>
