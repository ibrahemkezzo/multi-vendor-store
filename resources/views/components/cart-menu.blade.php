<div class="cart-items">
    <a href="javascript:void(0)" class="main-btn">
        <i class="lni lni-cart"></i>
        <span class="total-items">{{$items->count()}}</span>
    </a>
    <div class="shopping-item">
        <div class="dropdown-cart-header">
            <span>{{$items->count()}}</span>
            <a href="{{route('cart.index')}}">View Cart</a>
        </div>
        <ul class="shopping-list">

            @foreach ($items as $item)
                <li>

                    {{-- <a href="javascript:void(0)" class="remove" title="Remove this item"><i
                            class="lni lni-close"></i></a> --}}
                    <div class="col-lg-1 col-md-2 col-12 remove">
                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="remove"><i class="lni lni-close"></i></button>
                        </form>
                    </div>
                    <div class="cart-img-head">
                        <a class="cart-img" href="product-details.html"><img
                                src="{{$item->product->image_url}}" alt="#"></a>
                    </div>

                    <div class="content">
                        <h4><a href="product-details.html">
                                {{$item->product->name}}</a></h4>
                        <p class="quantity">{{$item->quantity}} - <span class="amount">
                            {{App\Helpers\Currency::formate($item->product->price*$item->quantity)}}
                            {{-- {{$item->product->price*$item->quantity}} --}}
                        </span></p>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="bottom">
            <div class="total">
                <span>Total</span>
                <span class="total-amount">
                    {{App\Helpers\Currency::formate($total)}}
                    {{-- {{$total}} --}}

                </span>
            </div>
            <div class="button">
                <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
            </div>
        </div>
    </div>
</div>

