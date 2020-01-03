<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="user-wrapper">
                    <div class="text-wrapper">
                        <p class="profile-name">{{ auth()->user()->name }}</p>
                        <div>
                            <small class="designation text-muted">Organizer</small>
                            <span class="status-indicator online"></span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('events.create') }}" class="btn btn-success btn-block">Create new event
                    <i class="mdi mdi-plus"></i>
                </a>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="menu-icon fa fa-chart-bar"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('events.index') }}">
                <i class="menu-icon fa fa-calendar-alt"></i>
                <span class="menu-title">Manage Events</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('organizer.contact') }}">
                <i class="menu-icon fa fa-user"></i>
                <span class="menu-title">Contact</span>
            </a>
        </li>
        @if(collect([
        'events.show',
        'tickets.create',
        'tickets.edit',
        'sessions.create',
        'events.edit',
        'events.room_capacity',
        'events.report',
        'events.attendees_verify_show'
        ])->contains(Route::currentRouteName()))
            <li class="nav-item event-title">
                <div class="nav-link font-weight-bold text-uppercase" style="white-space:normal">{{ $event->name }}</div>
            </li>
            <li class="nav-item @if(Route::currentRouteName() === 'event.show') active @endif">
                <a class="nav-link" href="{{ route('events.show', $event->id) }}">
                    <i class="menu-icon fa fa-clipboard-list"></i>
                    <span class="menu-title">Overview</span>
                </a>
            </li>
            <li class="nav-item @if(Route::currentRouteName() === 'events.attendees_verify_show') active @endif">
                <a class="nav-link" href="{{ route('events.attendees_verify_show', $event->id) }}">
                    <i class="menu-icon fa fa-clipboard-list"></i>
                    <span class="menu-title">Verify Attendees</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('events.report',$event->id) }}">
                    <i class="menu-icon fa fa-chart-bar"></i>
                    <span class="menu-title">Report</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('events.room_capacity', $event->id) }}">
                    <i class="menu-icon fa fa-building"></i>
                    <span class="menu-title">Room capacity</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('event.registration_show', ['event'=> $event->id]) }}">
                    <i class="menu-icon fa fa-building"></i>
                    <span class="menu-title">Attendee Registration</span>
                </a>
            </li>
        @endisset
    </ul>
</nav>
