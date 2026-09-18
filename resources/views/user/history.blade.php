@extends('layouts.user')

@section('title', 'History Pesanan - Njajan')

@section('content')
<div class="min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <div class="mb-12">
            <h1 class="text-4xl font-normal text-forest-shadow mb-3">History Pesanan</h1>
            <p class="text-lg text-warm-gray">Semua riwayat pesanan kamu.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-warm-gray/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left bg-deep-forest">
                        <tr class="text-white">
                            <th class="px-5 py-4 font-bold">Kode</th>
                            <th class="px-5 py-4 font-bold">Tanggal</th>
                            <th class="px-5 py-4 font-bold">Tenant</th>
                            <th class="px-5 py-4 font-bold">Total</th>
                            <th class="px-5 py-4 font-bold">Status</th>
                            <th class="px-5 py-4 font-bold">Struk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="border-t border-warm-gray/20 hover:bg-sage-mist/20 transition">
                                <td class="px-5 py-4 font-bold text-forest-shadow">{{ $order->kode }}</td>
                                <td class="px-5 py-4 text-warm-gray">{{ $order->order_date->translatedFormat('d M Y, H:i') }}</td>
                                <td class="px-5 py-4 text-forest-shadow">{{ $order->tenant->name ?? '-' }}</td>
                                <td class="px-5 py-4 font-bold text-deep-forest">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-5 py-4">
                                    @if ($order->status === 'selesai')
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-lime-glow text-deep-forest">Selesai</span>
                                    @elseif ($order->status === 'diproses')
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-warm-sand text-forest-shadow">Diproses</span>
                                    @elseif ($order->status === 'pending')
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-sage-mist text-deep-forest">Pending</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">Dibatalkan</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    @if ($order->payment_status === 'paid')
                                        <a href="{{ route('struk', $order->payment_group) }}" class="text-deep-forest hover:text-deep-forest/80 font-bold transition">
                                            📄 Struk
                                        </a>
                                    @else
                                        <span class="text-warm-gray">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center">
                                    <p class="text-6xl mb-4">📋</p>
                                    <p class="text-lg text-warm-gray">Belum ada riwayat pesanan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
