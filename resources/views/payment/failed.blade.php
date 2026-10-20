@extends('layouts.auth')
@section('title', 'Pembayaran Gagal')
@section('content')
<div class="text-center">
    <span class="inline-flex w-14 h-14 rounded-full items-center justify-center bg-red-100 text-red-800 mb-4"><x-icon name="x" class="w-7 h-7" /></span>
    <p class="text-warm-gray text-sm">Kode pembayaran</p>
    <p class="font-bold mb-4">{{ $payment->group_code }}</p>
    <p class="text-warm-gray mb-6">Pesanan tersimpan dengan status <strong>belum dibayar</strong>. Kamu bisa mencoba lagi dari halaman Pesanan.</p>
    <a href="{{ route('pesanan') }}" class="btn btn-primary">Ke Halaman Pesanan</a>
</div>
@endsection
