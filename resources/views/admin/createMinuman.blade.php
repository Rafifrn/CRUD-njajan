@extends('adminlte::page')

@section('title', 'Tambah Minuman')

@section('content_header')
    <h1>Tambah Minuman</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.minuman.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nama Minuman</label>
            <input type="text" name="name" class="form-control" required>
            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
            @error('price')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="region">Daerah</label>
            <input type="text" name="region" class="form-control" required>
            @error('region')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="image">Gambar (Opsional)</label>
            <input type="file" name="image" class="form-control-file">
            @error('image')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
@stop
