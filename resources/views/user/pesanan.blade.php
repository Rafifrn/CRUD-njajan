@extends('layouts.user')

@section('title', 'Pesanan Saya - Njajan')

@section('content')
<div class="min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <div class="mb-12">
            <h1 class="text-4xl font-normal text-forest-shadow mb-3">Pesanan Saya</h1>
            <p class="text-lg text-warm-gray">Status pesanan hari ini ({{ now()->translatedFormat('d F Y') }}).</p>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-sage-mist border border-deep-forest/20 text-deep-forest px-5 py-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @forelse ($orders as $order)
            <div class="bg-white rounded-xl shadow-sm border border-warm-gray/20 overflow-hidden mb-5 hover:shadow-md transition-shadow">
                <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-warm-gray/20 bg-sage-mist/30">
                    <div>
                        <span class="font-bold text-forest-shadow text-lg">{{ $order->kode }}</span>
                        <span class="text-warm-gray mx-2">•</span>
                        <span class="text-forest-shadow">{{ $order->tenant->name ?? 'Tanpa tenant' }}</span>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        @if ($order->payment_status === 'paid')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-lime-glow text-deep-forest">Lunas</span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-warm-sand text-forest-shadow">Belum Bayar</span>
                        @endif
                        @if ($order->status === 'pending')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-sage-mist text-deep-forest">Menunggu Konfirmasi</span>
                        @elseif ($order->status === 'diproses')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-warm-sand text-forest-shadow">Sedang Diproses</span>
                        @elseif ($order->status === 'selesai')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-lime-glow text-deep-forest">Selesai</span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">Dibatalkan</span>
                        @endif
                    </div>
                </div>
                <div class="px-6 py-5">
                    <ul class="space-y-2 text-sm text-forest-shadow">
                        @foreach ($order->orderItems as $item)
                            <li class="flex justify-between py-2 border-b border-warm-gray/10 last:border-0">
                                <span class="font-medium">{{ $item->qty }}× {{ $item->name }}</span>
                                <span class="font-bold">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="flex justify-between font-bold text-deep-forest text-lg mt-4 pt-4 border-t border-warm-gray/20">
                        <span>Total</span>
                        <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    @if ($order->payment_status === 'paid' && $order->status === 'selesai')
                        <a href="{{ route('struk', $order->payment_group) }}"
                           class="inline-block mt-4 text-sm font-bold text-deep-forest hover:text-deep-forest/80 transition">
                            📄 Lihat Struk Digital
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-20">
                <p class="text-6xl mb-4">🧾</p>
                <p class="text-lg text-warm-gray mb-6">Belum ada pesanan hari ini.</p>
                <a href="{{ route('order') }}" class="inline-block px-8 py-3 bg-lime-glow hover:bg-lime-glow/90 text-deep-forest font-bold rounded-full transition-colors">
                    Mulai Pesan
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
