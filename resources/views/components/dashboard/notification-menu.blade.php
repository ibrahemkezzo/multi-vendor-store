<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
      <i class="far fa-bell"></i>
      @if ($newCount)
      <span class="badge badge-warning navbar-badge">{{$newCount}}</span>
      @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" >
      <span class="dropdown-header">{{$newCount}} Notifications</span>
      <div class="dropdown-divider"></div>
      {{-- <a href="#" class="dropdown-item">
        <i class="fas fa-envelope mr-2"></i> 4 new messages
        <span class="float-right text-muted text-sm">3 mins</span>
      </a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">
        <i class="fas fa-users mr-2"></i> 8 friend requests
        <span class="float-right text-muted text-sm">12 hours</span>
      </a> --}}
      @foreach ($notifications as $notification)
      {{-- @dd($notification->unread()) --}}

      <div class="dropdown-divider"></div>
      <a href="{{$notification->data['url']}}?notification_id={{$notification->id}}" class="dropdown-item  @if ($notification->unread())text-blod @endif">
        <i class="{{$notification->data['icon']}} mr-2"> {{$notification->data['body']}}</i>

        <span class="float-right text-muted text-sm">{{$notification->created_at->longAbsoluteDiffForHumans()}}</span>
      </a>
      <div class="dropdown-divider"></div>
      @endforeach
      <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
  </li>
