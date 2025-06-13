@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container">
    <h1 class="mb-4">Daftar Pesanan Masuk</h1>

    @foreach ($orders as $order)
        <div class="card mb-3">
            <div class="card-header">
                <strong>Pesanan #{{ $order->id }}</strong> oleh {{ $order->user->name ?? 'User Tidak Dikenal' }} <br>
                <small>Dipesan pada: {{ $order->order_date->format('d M Y H:i') }}</small>
            </div>
            <div class="card-body">
                <ul>
                    @foreach ($order->items as $item)
                        <li>
                            {{ $item['name'] }} ({{ $item['quantity'] }} x Rp{{ number_format($item['price']) }}) 
                            = Rp{{ number_format($item['subtotal']) }}
                        </li>
                    @endforeach
                </ul>
                <p><strong>Total:</strong> Rp{{ number_format($order->total) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>
        </div>
    @endforeach
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
@stop