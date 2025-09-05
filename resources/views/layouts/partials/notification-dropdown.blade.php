<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        <i class="fa fa-bell"></i>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="badge badge-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="navbarDropdown">
        @if(auth()->user()->unreadNotifications->count() > 0)
            @foreach(auth()->user()->unreadNotifications->take(5) as $notification)
                <a class="dropdown-item" href="{{ route('notifications.index') }}">
                    <strong>{{ $notification->data['message'] }}</strong>
                    <small class="d-block text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                </a>
                @if(!$loop->last)
                    <div class="dropdown-divider"></div>
                @endif
            @endforeach
        @else
            <span class="dropdown-item">Aucune notification non lue</span>
        @endif
        
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-center" href="{{ route('notifications.index') }}">
            Voir toutes les notifications
        </a>
    </div>
</li>