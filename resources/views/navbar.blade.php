<nav class="navbar navbar-expand-md navbar-dark bg-warning fs-5">
    <div class="container">
        <a class="navbar-brand fs-2 text-secondary" href="/">
            <img src="{{ asset('img/Scratch_Cat.png') }}" alt="" height="60" class="d-inline-block align-text-baseline">
            {{ env('APP_NAME') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active fw-bold' : '' }}" aria-current="page" href="/">首頁</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('upload') ? 'active fw-bold' : '' }}" href="{{ route('upload') }}">作品上傳</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-md-0">
                @guest()
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('login') ? 'active fw-bold' : '' }}" aria-current="page" href="{{ route('login') }}">登入</a>
                    </li>
                @endguest
                @auth()
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">帳號資訊</a></li>
                            @if(auth()->user()->is_admin)
                                <li><a class="dropdown-item" href="{{ route('admin.teams.index') }}">名單管理</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">登出</a></li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
