<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ route('dashboard') }}">
            <img src="{{ asset('admin/images/logo-e.png') }}" alt="logo" /> </a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">
            <img src="{{ asset('admin/images/logo-e-mini.png') }}" alt="logo" /> </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-bell-outline"></i>
                    <span class="count" id="nav-bar-notify-num"
                          data-app-cluster="{{env("PUSHER_APP_CLUSTER")}}"
                          data-app-key="{{env("MIX_PUSHER_APP_KEY")}}">{{ count(auth()->user()->unreadNotifications) }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="messageDropdown">
                    <a class="dropdown-item py-3">
                        <p class="mb-0 font-weight-medium float-left" id="notify-sentence">You have {{ count(auth()->user()->unreadNotifications)  }} unread notification </p>
                        <span class="badge badge-pill badge-primary float-right" style="cursor: pointer" data-url="{{ route('organizer.notify') }}" id="view-all-notify">View all</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <div id="notification_container" data-o-id="{{ auth()->user()->id }}" data-one-url="{{ route('organizer.mask_as_read_one_notifications') }}">
                        @if(count(auth()->user()->unreadNotifications) < 5)
                            @foreach(auth()->user()->unreadNotifications as $noti)
                                <a class="dropdown-item preview-item notification-item" data-id="{{ $noti->id }}" style="cursor: pointer">
                                    <div class="preview-item-content flex-grow py-2">
                                        <p class="font-weight-medium text-dark">
                                            Attendee just register to event now
                                        </p>
                                        <p class="font-weight-light small-text">
                                            <strong>{{ $noti->data['attendee']['firstname'] . ' ' . $noti->data['attendee']['lastname'] }}</strong> just register to event <strong>{{ $noti->data['event']['name'] }}</strong>
                                        </p>
                                        <p class="text-muted text-right" style="font-size: 12px!important;">
                                            {{ date('d/m/Y H:i',strtotime($noti->created_at)) }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            @for ($i = 0; $i < 5; $i++)
                                <a class="dropdown-item preview-item">
                                    <div class="preview-item-content flex-grow py-2">
                                        <p class="font-weight-medium text-dark">
                                            Attendee just register to event now
                                        </p>
                                        <p class="font-weight-light small-text">
                                            <strong>{{ auth()->user()->unreadNotifications[$i]->data['attendee']['firstname'] . ' ' . auth()->user()->unreadNotifications[$i]->data['attendee']['lastname'] }}</strong> just register to event <strong>{{ auth()->user()->unreadNotifications[$i]->data['event']['name'] }}</strong>
                                        </p>
                                        <p class="text-muted text-right" style="font-size: 12px!important;">
                                            {{ date('d/m/Y H:i',strtotime(auth()->user()->unreadNotifications[$i]->created_at)) }}
                                        </p>
                                    </div>
                                </a>
                            @endfor
                        @endif
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown d-none d-xl-inline-block">
                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    {{ auth()->user()->name }}</a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <a href="{{ route('organizer.profile') }}" class="dropdown-item mt-3">
                        Profile
                    </a>
                    <a href="{{ route('organizer.show_change_password') }}" class="dropdown-item mt-3">
                        Change Password
                    </a>
                    <a href="#" style="cursor: pointer" class="dropdown-item" onclick="document.getElementById('logout-form').submit();"> Logout </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
