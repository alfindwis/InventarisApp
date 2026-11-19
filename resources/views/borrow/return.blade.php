@extends('layouts.app')

@section('title', 'Pengembalian Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Proses Pengembalian Barang</h3>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">Dashboard</a>
</div>

@forelse ($requests as $req)
    @php
        $isOverdue = \Carbon\Carbon::today()->gt(\Carbon\Carbon::parse($req->due_date));
    @endphp

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div>
                <strong>{{ $req->transaction_code }}</strong>
                <span class="text-muted ms-2">Peminjam: {{ $req->borrower->name ?? '-' }}</span>
            </div>
            <div>
                <span class="badge bg-primary">Pinjam: {{ $req->borrow_date ?? '-' }}</span>
                <span class="badge {{ $isOverdue ? 'bg-danger' : 'bg-secondary' }}">
                    Tenggat: {{ $req->due_date }}
                </span>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('petugas.processReturn', $req->id) }}" method="POST">
                @csrf

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Barang</th>
                                <th class="text-center" style="width: 110px;">Jumlah</th>
                                <th style="width: 170px;">Kondisi Akhir</th>
                                <th>Catatan Pengembalian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($req->details as $detail)
                                @php
                                    $latestCondition = $detail->itemConditions->last();
                                @endphp
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $detail->item->item_name ?? '-' }}</div>
                                        <small class="text-muted">
                                            Kode: {{ $detail->item->item_code ?? '-' }} |
                                            Kondisi Awal: {{ $latestCondition->condition_before ?? 'Baik' }}
                                        </small>
                                    </td>
                                    <td class="text-center fw-bold">{{ $detail->quantity }}</td>
                                    <td>
                                        <select name="cond_after[{{ $detail->id }}]" class="form-select form-select-sm" required>
                                            <option value="Baik" selected>Baik</option>
                                            <option value="Rusak">Rusak</option>
                                            <option value="Hilang">Hilang</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text"
                                               name="notes[{{ $detail->id }}]"
                                               class="form-control form-control-sm"
                                               placeholder="Catatan kondisi / kerusakan / kehilangan">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Proses Pengembalian</button>
                </div>
            </form>
        </div>
    </div>
@empty
    <div class="alert alert-secondary">Tidak ada barang yang sedang dalam status dipinjam (BORROWED).</div>
@endforelse
@endsection