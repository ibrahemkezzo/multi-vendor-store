<div class="col-lg-4 col-md-6 col-12">
    <!-- Start Single Category -->
    <div class="single-category" style="height: 250px; overflow: hidden;">
        <a href="{{route('front.department.filter-store',$department->id)}}">
            <h3 class="heading">{{$department->name}} </h3>
        </a>
        <ul>
            @foreach ($department->stores->take(3) as $store)

            <li><a href="{{route('shop.stores.show',$store->slug)}}">{{$store->name}}</a></li>
            @endforeach
            <li>...<a href="{{route('front.department.filter-store',$department->id)}}">view all stores</a></li>
        </ul>
        <div class="images">
            <img src="{{$department->image}}" alt="#">
        </div>
    </div>
    <!-- End Single Category -->
</div>