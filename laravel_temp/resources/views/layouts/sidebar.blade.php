    {{-- Sidebar AdminLTE 3 --}}
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column"
        data-widget="treeview"
        role="menu"
        data-accordion="false">

        {{-- DASHBOARD --}}
        <li class="nav-item">
            <a href="{{ url('/admin') }}"
               class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>Dashboard</p>
            </a>
        </li>

        {{-- MANAJEMEN TOKO --}}
        <li class="nav-header">MANAJEMEN TOKO</li>

        <li class="nav-item">
            <a href="{{ url('/admin/products') }}"
               class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-box-open"></i>
                <p>Data Produk</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ url('/admin/categories') }}"
               class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-layer-group"></i>
                <p>Kategori Produk</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ url('/admin/orders') }}"
               class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-receipt"></i>
                <p>Pesanan</p>
            </a>
        </li>

        {{-- ULASAN PRODUK --}}
        <li class="nav-item">
            <a href="{{ route('admin.ulasan.index') }}"
               class="nav-link {{ request()->routeIs('admin.ulasan.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-star"></i>
                <p>Ulasan Produk</p>
            </a>
        </li>

        {{-- PENGGUNA --}}
        <li class="nav-header">PENGGUNA</li>

        <li class="nav-item">
            <a href="{{ url('/admin/users') }}"
               class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Kelola Pengguna</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ url('/admin/profile') }}"
               class="nav-link {{ request()->is('admin/profile*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-cog"></i>
                <p>Profil</p>
            </a>
        </li>

        {{-- LIHAT TOKO --}}
        <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link">
                <i class="nav-icon fas fa-store"></i>
                <p>Lihat Toko</p>
            </a>
        </li>

        {{-- LOGOUT --}}
        <li class="nav-item">
            <form action="{{ url('/logout') }}"
                  method="POST"
                  class="d-none"
                  id="sidebar-logout-form">
                @csrf
            </form>

            <a href="#"
               class="nav-link"
               onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Logout</p>
            </a>
        </li>

    </ul>
</nav>
