
<div class="col-lg-4 col-md-6 col-12 row" style="">
    <div class="" style="width:32em; height:12em; margin-left:-1px; margin-top:15px">
        <img src="{{asset('storage/'.$department->image)}}" alt="#">
    </div>
    <!-- Start Single Category -->

    <div class="single-category mt-10" style=" overflow: hidden;">
        <div style="height: 150px;">
            <a href="{{route('front.department.filter-store',$department->id)}}">
                <h3 class="heading">{{$department->name}} </h3>
            </a>
            <ul>
                @foreach ($department->stores->take(3) as $store)

                <li><a href="{{route('shop.stores.show',$store->slug)}}">{{$store->name}}</a></li>
                @endforeach
                @if ($department->stores->count() > 3)
                <li>...<a href="{{route('front.department.filter-store',$department->id)}}">view all stores</a></li>
                @endif
            </ul>
        </div>

    </div>

    <!-- End Single Category -->
</div>