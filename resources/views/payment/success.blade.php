@extends('layouts.auth')
@section('title', 'Pembayaran Berhasil')
@section('content')
<div class="text-center">
    <span class="inline-flex w-14 h-14 rounded-full items-center justify-center bg-lime-glow text-coffee-bean mb-4"><x-icon name="check" class="w-7 h-7" /></span>
    <p class="text-warm-gray text-sm">Kode pembayaran</p>
    <p class="font-bold mb-4">{{ $payment->group_code }}</p>
    <p class="text-3xl font-bold mb-5">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>
    <div class="text-left bg-sage-mist/60 rounded-xl p-4 mb-6 space-y-2 text-sm">
        @foreach ($payment->orders as $order)
            <div class="flex justify-between gap-3"><span>{{ $order->tenant->name ?? '-' }} <span class="text-warm-gray">({{ $order->kode }})</span></span><span class="font-bold whitespace-nowrap">Rp{{ number_format($order->total, 0, ',', '.') }}</span></div>
        @endforeach
        <p class="text-xs text-warm-gray pt-2 border-t border-warm-sand">Pesanan sudah diteruskan ke tiap tenant. Pantau statusnya di halaman Pesanan.</p>
    </div>
    <div class="flex gap-3 justify-center flex-wrap">
        <a href="{{ route('struk', $payment->group_code) }}" class="btn btn-primary">Lihat Struk</a>
        <a href="{{ route('pesanan') }}" class="btn btn-soft">Pesanan Saya</a>
    </div>
</div>
@endsection
