<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" width="30" height="30"
                    src="{{ Auth::user()->image === 'default' ? asset('defaultUser.png') : asset('storage/' . Auth::user()->image) }}"
                    alt="image" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block speakable">Hi, {{Auth::user()->nama}}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title speakable">Management Akun</div>
                <a href="/admin/profil" class="dropdown-item has-icon speakable">
                    <i class="far fa-user"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="/logout" class="dropdown-item has-icon text-danger speakable" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </a>
                <form method="POST" id="logout-form" action="/logout">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
