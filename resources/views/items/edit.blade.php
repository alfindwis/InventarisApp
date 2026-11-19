{{-- resources/views/items/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<h3 class="mb-3">Edit Barang</h3>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('items.update', $item) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id', $item->category_id) == $cat->id)>
                                {{ $cat->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="item_code" class="form-label">Kode Barang</label>
                    <input type="text" name="item_code" id="item_code"
                           value="{{ old('item_code', $item->item_code) }}"
                           class="form-control @error('item_code') is-invalid @enderror" required>
                    @error('item_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-12">
                    <label for="item_name" class="form-label">Nama Barang</label>
                    <input type="text" name="item_name" id="item_name"
                           value="{{ old('item_name', $item->item_name) }}"
                           class="form-control @error('item_name') is-invalid @enderror" required>
                    @error('item_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label for="stock_total" class="form-label">Stok Total</label>
                    <input type="number" name="stock_total" id="stock_total"
                           value="{{ old('stock_total', $item->stock_total) }}" min="0"
                           class="form-control @error('stock_total') is-invalid @enderror" required>
                    @error('stock_total') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label for="stock_damaged" class="form-label">Stok Rusak</label>
                    <input type="number" name="stock_damaged" id="stock_damaged"
                           value="{{ old('stock_damaged', $item->stock_damaged) }}" min="0"
                           class="form-control @error('stock_damaged') is-invalid @enderror">
                    @error('stock_damaged') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label for="stock_lost" class="form-label">Stok Hilang</label>
                    <input type="number" name="stock_lost" id="stock_lost"
                           value="{{ old('stock_lost', $item->stock_lost) }}" min="0"
                           class="form-control @error('stock_lost') is-invalid @enderror">
                    @error('stock_lost') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label for="minimum_stock" class="form-label">Stok Minimum</label>
                    <input type="number" name="minimum_stock" id="minimum_stock"
                           value="{{ old('minimum_stock', $item->minimum_stock) }}" min="0"
                           class="form-control @error('minimum_stock') is-invalid @enderror" required>
                    @error('minimum_stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('items.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection