<div class="header flex justify-between">
    <div class="logo">
        <a href="/" class="logo-icon">
            <img src="{{ asset('Azuraya.png') }}" width="35" height="35" alt="Azuraya">
        </a>
    </div>
    <div class="main-menu self-center hidden md:block">
        <ul class="nav flex space-x-275 justify-content-center">
            <li class="nav-item">
                <a class="nav-link navigasi speakable {{ Request::is('/') ? 'active' : '' }}" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link navigasi speakable {{ Request::is('produk') ? 'active' : '' }}" href="/produk">Produk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link navigasi speakable {{ Request::is('hubungi-kami') ? 'active' : '' }}" href="/hubungi-kami">Hubungi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link navigasi speakable {{ Request::is('tentang-kami') ? 'active ' : '' }}" href="/tentang-kami">Tentang</a>
            </li>
        </ul>
    </div>
    <div class="icon-wrapper flex justify-between space-x-1">
        <div class="mini-cart-wrapper self-center">
            <a class="mini-cart-icon" href="{{ Auth::check() ? '/keranjang/' . Auth::user()->username : '/login' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" aria-hidden="true" width="20" height="20">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span>{{ $dataKeranjang->count() }}</span>
            </a>
        </div>
        @if (Auth::check())
            <div class="self-center">
                <a href="/riwayat-pesanan/{{ Auth::user()->username }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" width="25" height="25">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8V12l4 2M12 2a10 10 0 100 20 10 10 0 000-20z"></path>
                    </svg>
                </a>
            </div>
        @endif
        <div class="self-center">
            <a href="{{ Auth::check() ? '/profil/' . Auth::user()->username : '/login' }}">
                @if (Auth::check())
                <img style="object-fit: fill;width: 25px;height: 25px;border-radius: 50%" src="{{ Auth::user()->image === 'default' ? asset('defaultUser.png') : asset('storage/' . Auth::user()->image) }}" alt="Image"/>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" width="25" height="25">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                @endif
            </a>
        </div>
        <div class="main-menu-mobile self-center">
            <a class="menu-icon" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </a>
        </div>        
    </div>
</div>
