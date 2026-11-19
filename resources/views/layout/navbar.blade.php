@php $role = auth()->user()->role ?? null; @endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">InventarisApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            @auth
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>

                    @if ($role === 'admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Pengguna</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Kategori</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('items.index') }}">Barang</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.requests') }}">Persetujuan</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('reports.inventory') }}">Lap. Stok</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('reports.history') }}">Lap. Peminjaman</a></li>
                    @elseif ($role === 'petugas')
                        <li class="nav-item"><a class="nav-link" href="{{ route('petugas.handoverForm') }}">Penyerahan</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('petugas.returnForm') }}">Pengembalian</a></li>
                    @elseif ($role === 'peminjam')
                        <li class="nav-item"><a class="nav-link" href="{{ route('borrow.create') }}">Ajukan Pinjam</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('borrow.myrequests') }}">Riwayat Saya</a></li>
                    @endif
                </ul>

                <div class="d-flex align-items-center text-light gap-3">
                    <span class="small">{{ auth()->user()->name }} <span class="badge bg-secondary text-uppercase">{{ $role }}</span></span>
                    @if (\Illuminate\Support\Facades\Route::has('logout'))
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>