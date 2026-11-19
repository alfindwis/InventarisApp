@extends('layouts.app')

@section('title', 'Dashboard - InventarisApp')

@section('content')
<h3 class="mb-4">Dashboard</h3>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Total Barang</div>
                <div class="fs-4 fw-bold">{{ $stats['total_items'] ?? 0 }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Stok Menipis</div>
                <div class="fs-4 fw-bold text-warning">{{ $stats['low_stock_items'] ?? 0 }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Menunggu Approval (PENDING)</div>
                <div class="fs-4 fw-bold text-primary">{{ $stats['pending_requests'] ?? 0 }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Sedang Dipinjam (BORROWED)</div>
                <div class="fs-4 fw-bold text-success">{{ $stats['borrowed_requests'] ?? 0 }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold">Pengajuan Peminjaman Terbaru</div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Peminjam</th>
                    <th>Tenggat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentRequests ?? [] as $req)
                    <tr>
                        <td>{{ $req->transaction_code }}</td>
                        <td>{{ $req->borrower->name ?? '-' }}</td>
                        <td>{{ $req->due_date }}</td>
                        <td><span class="badge bg-secondary">{{ $req->status }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada data transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection