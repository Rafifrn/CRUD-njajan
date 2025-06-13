@extends('adminlte::page')

@section('title', 'Tambah Minuman')

@section('content_header')
    <h1>Tambah Minuman</h1>
@stop

@section('content')
<div class="container mt-4">
    <h2>Daftar Minuman</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.minuman.create') }}" class="btn btn-primary mb-3">Tambah Minuman</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Slug</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Region</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($minumans as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->slug }}</td>
                <td>{{ $item->description }}</td>
                <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                <td>{{ $item->region }}</td>
                <td>
                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" width="80">
                    @else
                        <small class="text-muted">Tidak ada gambar</small>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.minuman.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('admin.minuman.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach

            @if($minumans->isEmpty())
                <tr><td colspan="7" class="text-center">Data tidak tersedia.</td></tr>
            @endif
        </tbody>
    </table>
</div>
@stop
