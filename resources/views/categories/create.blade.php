{{-- resources/views/categories/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<h3 class="mb-3">Tambah Kategori</h3>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="category_name" class="form-label">Nama Kategori</label>
                <input type="text" name="category_name" id="category_name" value="{{ old('category_name') }}" class="form-control @error('category_name') is-invalid @enderror" required>
                @error('category_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Keterangan</label>
                <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection