@extends('layouts.app')

@section('title', 'Riwayat Peminjaman Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Riwayat Peminjaman Saya</h3>
    <a href="{{ route('borrow.create') }}" class="btn btn-primary btn-sm">+ Ajukan Peminjaman</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Barang</th>
                    <th>Tenggat</th>
                    <th>Status</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $req)
                    <tr>
                        <td class="fw-semibold">{{ $req->transaction_code }}</td>
                        <td>
                            <ul class="mb-0 ps-3">
                                @foreach ($req->details as $d)
                                    <li>{{ $d->item->item_name ?? '-' }} ({{ $d->quantity }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $req->due_date }}</td>
                        <td><span class="badge bg-secondary">{{ $req->status }}</span></td>
                        <td>{{ $req->notes ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection