@extends('layouts.app')

@section('title', 'Laporan Inventaris')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Laporan Stok Inventaris</h3>
    <button type="button" onclick="window.print()" class="btn btn-outline-dark btn-sm">Cetak Laporan</button>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Total</th>
                    <th>Tersedia</th>
                    <th>Dipinjam</th>
                    <th>Rusak</th>
                    <th>Hilang</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->item_code }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->category->category_name ?? '-' }}</td>
                        <td>{{ $item->stock_total }}</td>
                        <td>{{ $item->stock_available }}</td>
                        <td>{{ $item->stock_borrowed }}</td>
                        <td>{{ $item->stock_damaged }}</td>
                        <td>{{ $item->stock_lost }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Tidak ada data barang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection