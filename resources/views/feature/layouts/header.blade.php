<header class="header">
    <div class="logo-container">
        <a class="logo">
            Test HashMicro
        </a>

        <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <!-- start: search & user box -->
    <div class="header-right">
        <span class="separator"></span>

        <div id="userbox" class="userbox">
            <a href="#" data-bs-toggle="dropdown">
                <figure class="profile-picture">
                    <!-- <img src="{{env('APP_URL') . '/images/users/blank_profile_picture.png'}}" alt="Joseph Doe" class="rounded-circle" data-lock-picture="img/!logged-user.jpg" /> -->
                </figure>
                <div class="profile-info">
                    <span class="name">{{Auth::user()->email}}</span>
                </div>

                <i class="fa custom-caret"></i>
            </a>

            <div class="dropdown-menu">
                <ul class="list-unstyled mb-2">
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bx bx-power-off"></i> Logout</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>