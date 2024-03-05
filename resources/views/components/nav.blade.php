<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      <li class="nav-item menu-open">
        <div class="nav-link active">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Starter Pages
            <i class="right fas fa-angle-left"></i>
          </p>
        </div>
        <ul class="nav nav-treeview">
            @foreach ($items as $item)

            <li class="nav-item">
                <a href="{{route($item['route'])}}" class="nav-link {{--{{($active == $item['route'])?'active':''}}--}}
                {{(Route::is($item['active'])?'active':'')}}">
                    <i class="{{$item['icon']}}" ></i>
                    <p>{{$item['title']}}</p>
                </a>
            </li>

            @endforeach
        </ul>
      </li>

    </ul>
  </nav>
  <!-- /.sidebar-menu -->
