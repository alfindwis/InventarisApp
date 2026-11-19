@extends('layouts.app')

@section('title', 'Penyerahan Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Penyerahan Barang Disetujui</h3>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">Dashboard</a>
</div>

@forelse ($requests as $req)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div>
                <strong>{{ $req->transaction_code }}</strong>
                <span class="text-muted ms-2">Peminjam: {{ $req->borrower->name ?? '-' }}</span>
            </div>
            <span class="badge bg-info text-dark">Tenggat: {{ $req->due_date }}</span>
        </div>

        <div class="card-body">
            <form action="{{ route('petugas.handover', $req->id) }}" method="POST">
                @csrf

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Barang</th>
                                <th class="text-center" style="width: 110px;">Jumlah</th>
                                <th style="width: 180px;">Kondisi Awal</th>
                                <th>Catatan Pemeriksaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($req->details as $detail)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $detail->item->item_name ?? '-' }}</div>
                                        <small class="text-muted">
                                            Kode: {{ $detail->item->item_code ?? '-' }} |
                                            Tersedia: {{ $detail->item->stock_available ?? 0 }}
                                        </small>
                                    </td>
                                    <td class="text-center fw-bold">{{ $detail->quantity }}</td>
                                    <td>
                                        <select name="cond_before[{{ $detail->id }}]" class="form-select form-select-sm">
                                            <option value="Baik" selected>Baik</option>
                                            <option value="Rusak Ringan">Rusak Ringan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text"
                                               name="notes[{{ $detail->id }}]"
                                               class="form-control form-control-sm"
                                               placeholder="Opsional, misal: kabel lengkap">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Konfirmasi Serahkan Barang</button>
                </div>
            </form>
        </div>
    </div>
@empty
    <div class="alert alert-secondary">Tidak ada pengajuan berstatus APPROVED yang menunggu penyerahan.</div>
@endforelse
@endsection