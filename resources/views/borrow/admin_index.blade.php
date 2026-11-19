@extends('layouts.app')

@section('title', 'Persetujuan Pengajuan Peminjaman')

@section('content')
<h3 class="mb-3">Daftar Pengajuan Peminjaman</h3>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Peminjam</th>
                    <th>Barang</th>
                    <th>Tenggat</th>
                    <th>Status</th>
                    <th style="width: 190px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $req)
                    <tr>
                        <td class="fw-semibold">{{ $req->transaction_code }}</td>
                        <td>{{ $req->borrower->name ?? '-' }}</td>
                        <td>
                            <ul class="mb-0 ps-3">
                                @foreach ($req->details as $d)
                                    <li>{{ $d->item->item_name ?? '-' }} ({{ $d->quantity }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $req->due_date }}</td>
                        <td><span class="badge bg-info text-dark">{{ $req->status }}</span></td>
                        <td>
                            @if ($req->status === 'PENDING')
                                <form action="{{ route('admin.approve', $req->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                                </form>
                                <form action="{{ route('admin.reject', $req->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                </form>
                            @else
                                <span class="text-muted small">Diproses</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada pengajuan peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection