@extends('layouts.user')
@section('title', 'Pesanan Saya — Njajan')
@section('content')
<h1 class="page-title">Pesanan Saya</h1>
<p class="page-sub mb-6">Status pesanan hari ini · {{ now()->translatedFormat('d F Y') }}</p>
@if (session('success'))<div class="mb-6 p-4 rounded-xl bg-sage-mist text-deep-forest" role="status">{{ session('success') }}</div>@endif

<div class="space-y-5">
@forelse ($orders as $order)
    <article class="card overflow-hidden">
        <header class="px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-sage-mist/60 border-b border-warm-sand/60">
            <div><span class="font-bold text-lg">{{ $order->kode }}</span><span class="mx-2 text-warm-gray">•</span><span>{{ $order->tenant->name ?? 'Tanpa tenant' }}</span></div>
            <div class="flex gap-2 flex-wrap">
                <span class="badge {{ $order->payment_status === 'paid' ? 'bg-lime-glow text-coffee-bean' : 'bg-amber-200 text-coffee-bean' }}">{{ $order->payment_status === 'paid' ? 'Lunas' : 'Belum bayar' }}</span>
                @include('partials.order-status', ['status' => $order->status])
            </div>
        </header>
        <div class="px-6 py-5">
            <ul class="divide-y divide-warm-sand/50 text-sm">
                @foreach ($order->orderItems as $item)
                    <li class="flex justify-between py-2.5"><span class="font-medium">{{ $item->qty }}× {{ $item->name }}</span><span class="font-bold">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span></li>
                @endforeach
            </ul>
            <div class="flex justify-between font-bold text-lg mt-3 pt-3 border-t border-warm-sand"><span>Total</span><span>Rp{{ number_format($order->total, 0, ',', '.') }}</span></div>
            @if ($order->payment_status === 'paid' && $order->status === 'selesai')
                <a href="{{ route('struk', $order->payment_group) }}" class="btn btn-soft btn-sm mt-4"><x-icon name="receipt" class="w-4 h-4" /> Lihat struk digital</a>
            @endif
        </div>
    </article>
@empty
    <div class="text-center py-20">
        <x-icon name="receipt" class="w-14 h-14 mx-auto text-warm-gray mb-3" />
        <p class="text-lg text-warm-gray mb-6">Belum ada pesanan hari ini.</p>
        <a href="{{ route('order') }}" class="btn btn-primary">Mulai Pesan</a>
    </div>
@endforelse
</div>
@endsection
