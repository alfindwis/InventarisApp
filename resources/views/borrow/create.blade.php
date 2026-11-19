@extends('layouts.app')

@section('title', 'Ajukan Peminjaman Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Form Pengajuan Peminjaman</h3>
    <a href="{{ route('borrow.myrequests') }}" class="btn btn-outline-secondary btn-sm">Riwayat Saya</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('borrow.store') }}" method="POST">
            @csrf

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="due_date" class="form-label">Tanggal Tenggat Kembali <span class="text-danger">*</span></label>
                    <input type="date"
                           name="due_date"
                           id="due_date"
                           value="{{ old('due_date') }}"
                           min="{{ now()->addDay()->toDateString() }}"
                           class="form-control @error('due_date') is-invalid @enderror"
                           required>
                    @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="notes" class="form-label">Keperluan / Catatan</label>
                    <input type="text"
                           name="notes"
                           id="notes"
                           value="{{ old('notes') }}"
                           placeholder="Contoh: Praktikum jaringan / kegiatan UKM"
                           class="form-control @error('notes') is-invalid @enderror">
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Daftar Barang yang Dipinjam</h6>
                <button type="button" id="add-item-btn" class="btn btn-sm btn-outline-primary">+ Tambah Baris Barang</button>
            </div>

            <div id="items-container">
                @php $oldItems = old('items', [['item_id' => '', 'quantity' => 1]]); @endphp
                @foreach ($oldItems as $index => $oldItem)
                    <div class="row g-2 align-items-end item-row mb-2">
                        <div class="col-md-7">
                            <label class="form-label">Barang</label>
                            <select name="items[{{ $index }}][item_id]"
                                    class="form-select @error("items.$index.item_id") is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}"
                                        @selected(($oldItem['item_id'] ?? '') == $item->id)>
                                        {{ $item->item_code }} - {{ $item->item_name }} (Tersedia: {{ $item->stock_available }})
                                    </option>
                                @endforeach
                            </select>
                            @error("items.$index.item_id")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number"
                                   name="items[{{ $index }}][quantity]"
                                   value="{{ $oldItem['quantity'] ?? 1 }}"
                                   min="1"
                                   class="form-control @error("items.$index.quantity") is-invalid @enderror"
                                   required>
                            @error("items.$index.quantity")
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-danger w-100 remove-item-btn">Hapus</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const container = document.getElementById('items-container');
        const addBtn = document.getElementById('add-item-btn');
        let rowIndex = container.querySelectorAll('.item-row').length;

        const itemOptionsHtml = `@foreach ($items as $item)<option value="{{ $item->id }}">{{ $item->item_code }} - {{ $item->item_name }} (Tersedia: {{ $item->stock_available }})</option>@endforeach`;

        addBtn.addEventListener('click', function () {
            const div = document.createElement('div');
            div.className = 'row g-2 align-items-end item-row mb-2';
            div.innerHTML = `
                <div class="col-md-7">
                    <label class="form-label">Barang</label>
                    <select name="items[${rowIndex}][item_id]" class="form-select" required>
                        <option value="">-- Pilih Barang --</option>
                        ${itemOptionsHtml}
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="items[${rowIndex}][quantity]" value="1" min="1" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger w-100 remove-item-btn">Hapus</button>
                </div>
            `;
            container.appendChild(div);
            rowIndex++;
        });

        container.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-item-btn')) {
                const rows = container.querySelectorAll('.item-row');
                if (rows.length > 1) {
                    e.target.closest('.item-row').remove();
                }
            }
        });
    })();
</script>
@endpush