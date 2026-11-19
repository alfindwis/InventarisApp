{{-- resources/views/items/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')
<h3 class="mb-3">Tambah Barang</h3>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('items.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->category_name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="item_code" class="form-label">Kode Barang</label>
                    <input type="text" name="item_code" id="item_code" value="{{ old('item_code') }}"
                           class="form-control @error('item_code') is-invalid @enderror" required>
                    @error('item_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-12">
                    <label for="item_name" class="form-label">Nama Barang</label>
                    <input type="text" name="item_name" id="item_name" value="{{ old('item_name') }}"
                           class="form-control @error('item_name') is-invalid @enderror" required>
                    @error('item_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="stock_total" class="form-label">Stok Total Awal</label>
                    <input type="number" name="stock_total" id="stock_total" value="{{ old('stock_total', 0) }}" min="0"
                           class="form-control @error('stock_total') is-invalid @enderror" required>
                    @error('stock_total') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="minimum_stock" class="form-label">Batas Stok Minimum</label>
                    <input type="number" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock', 0) }}" min="0"
                           class="form-control @error('minimum_stock') is-invalid @enderror" required>
                    @error('minimum_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('items.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection