<div class="col-lg-3 col-md-6 col-12">


    <!-- Start Single Product -->
    <div class="single-product" style="height: 37em;">
        <div class="product-image">
            <img src="{{asset('storage/'.$product->image)}}"  height="330em" alt="#">
            <span class="sale-tag">{{$product->sale_percent}}%</span>
            {{-- <span class="new-tag">New</span> --}}
            <div class="button">
                <a href="{{route('product.show',$product->slug)}}" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
            </div>
        </div>
        <div class="product-info">
            <span class="category">{{$product->category->name}}</span>
            <h4 class="title">
                <a href="{{route('product.show',$product->slug)}}">{{$product->name}}</a>
            </h4>
            <ul class="review">
                <li><i class="lni lni-star-filled"></i></li>
                <li><i class="lni lni-star-filled"></i></li>
                <li><i class="lni lni-star-filled"></i></li>
                <li><i class="lni lni-star-filled"></i></li>
                <li><i class="lni lni-star"></i></li>
                <li><span>4.0 Review(s)</span></li>
            </ul>
            <div class="price">
                <span>{{currency::formate($product->price)}}</span>
                {{-- {{$product->price}} --}}

                @if ($product->compare_price)
                <span class="discount-price">{{currency::formate($product->compare_price) }}</span>
                {{-- <span  class="discount-price">{{$product->compare_price }}</span> --}}
                @endif
            </div>
        </div>
    </div>
    <!-- End Single Product -->
</div>
