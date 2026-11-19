@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Data Barang</h3>
    <a href="{{ route('items.create') }}" class="btn btn-primary">Tambah Barang</a>
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
                    <th style="width: 170px;">Aksi</th>
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
                        <td class="fw-semibold text-success">{{ $item->stock_available }}</td>
                        <td>{{ $item->stock_borrowed }}</td>
                        <td>{{ $item->stock_damaged }}</td>
                        <td>{{ $item->stock_lost }}</td>
                        <td>
                            <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus barang?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">Belum ada data barang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection