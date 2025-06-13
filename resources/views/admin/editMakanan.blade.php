@extends('adminlte::page')

@section('title', 'Tambah Makanan')

@section('content_header')
    <h1>Tambah Makanan</h1>
@stop

@section('content')
    <div class="container mt-5">
    <h2>Edit Makanan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.makanan.update', $makanan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Makanan</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $makanan->name) }}" required>
            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" class="form-control">{{ old('description', $makanan->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $makanan->price) }}" required>
            @error('price')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="form-group">
            <label for="region">Daerah</label>
            <input type="text" name="region" class="form-control" value="{{ old('region', $makanan->region) }}" required>
            @error('region')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="form-group">
            <label>Gambar Saat Ini</label><br>
            @if($makanan->image)
                <img src="{{ asset('storage/' . $makanan->image) }}" width="120">
            @else
                <p class="text-muted">Tidak ada gambar</p>
            @endif
        </div>

        <div class="form-group">
            <label for="image">Ganti Gambar (opsional)</label>
            <input type="file" name="image" class="form-control-file">
            @error('image')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.makanan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@stop
