<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a class="speakable" href="/admin/dashboard">AZURAYA</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/admin/dashboard"><img src="{{asset('icon.png')}}" alt="" srcset="" style="width: 25px; height: 25px;"></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header speakable">DASHBOARD</li>
            <li><a class="nav-link {{ $judul=="Dashboard" ? 'active' : '' }}" href="/admin/dashboard"><i class="fas fa-fire"></i> <span class="speakable">Dashboard</span></a></li>

            <li class="menu-header speakable">MASTER</li>
            <li><a class="nav-link {{ $judul=="Kategori" ? 'active' : '' }}" href="/admin/produk-kategori"><i class="fas fa-star"></i> <span class="speakable">Kategori</span></a></li>
            <li><a class="nav-link {{ $judul=="Produk" ? 'active' : '' }}" href="/admin/produk"><i class="fas fa-box"></i> <span class="speakable">Produk</span></a></li>

            <li class="menu-header speakable">TRANSASKI</li>
            <li><a class="nav-link {{ $judul=="Pesanan" ? 'active' : '' }}" href="/admin/pesanan"><i class="fas fa-shopping-bag"></i> <span class="speakable">Pesanan</span></a></li>

        </ul>
    </aside>
</div>
