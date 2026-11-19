@extends('layouts.app')

@section('title', 'Laporan Riwayat Peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Laporan Riwayat Peminjaman</h3>
    <button type="button" onclick="window.print()" class="btn btn-outline-dark btn-sm">Cetak Laporan</button>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Peminjam</th>
                    <th>Barang</th>
                    <th>Tgl Pinjam</th>
                    <th>Tenggat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $req)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $req->transaction_code }}</td>
                        <td>{{ $req->borrower->name ?? '-' }}</td>
                        <td>
                            <ul class="mb-0 ps-3">
                                @foreach ($req->details as $d)
                                    <li>{{ $d->item->item_name ?? '-' }} ({{ $d->quantity }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $req->borrow_date ?? '-' }}</td>
                        <td>{{ $req->due_date }}</td>
                        <td><span class="badge bg-secondary">{{ $req->status }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection