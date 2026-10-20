@extends('layouts.user')
@section('title', 'Riwayat Pesanan — Njajan')
@section('content')
<h1 class="page-title">Riwayat Pesanan</h1>
<p class="page-sub mb-6">Semua pesanan yang pernah kamu buat.</p>
<div class="card overflow-hidden">
    <div>
        <table class="w-full text-sm max-md:block">
            <thead class="table-head text-left max-md:hidden"><tr>
                <th scope="col" class="px-5 py-3.5">Kode</th><th scope="col" class="px-5 py-3.5">Tanggal</th><th scope="col" class="px-5 py-3.5">Tenant</th>
                <th scope="col" class="px-5 py-3.5">Total</th><th scope="col" class="px-5 py-3.5">Status</th><th scope="col" class="px-5 py-3.5">Struk</th>
            </tr></thead>
            <tbody class="max-md:block">
            @forelse ($orders as $order)
                <tr class="border-t border-warm-sand/60 hover:bg-sage-mist/40 max-md:grid max-md:grid-cols-2 max-md:items-center max-md:gap-y-1.5 max-md:p-4">
                    <td class="max-md:p-0 max-md:order-1 px-5 py-3.5 font-bold">{{ $order->kode }}</td>
                    <td class="max-md:p-0 max-md:order-4 max-md:text-right max-md:text-xs px-5 py-3.5 text-warm-gray whitespace-nowrap">{{ $order->order_date->translatedFormat('d M Y, H:i') }}</td>
                    <td class="max-md:p-0 max-md:order-3 max-md:text-warm-gray px-5 py-3.5">{{ $order->tenant->name ?? '-' }}</td>
                    <td class="max-md:p-0 max-md:order-5 max-md:text-lg px-5 py-3.5 font-bold whitespace-nowrap">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="max-md:p-0 max-md:order-2 max-md:justify-self-end px-5 py-3.5">@include('partials.order-status', ['status' => $order->status])</td>
                    <td class="max-md:p-0 max-md:order-6 max-md:justify-self-end px-5 py-3.5">
                        @if ($order->payment_status === 'paid')
                            <a href="{{ route('struk', $order->payment_group) }}" class="inline-flex items-center gap-1.5 font-bold text-mauve-bark hover:underline"><x-icon name="receipt" class="w-4 h-4" /> Struk</a>
                        @else <span class="text-warm-gray">-</span> @endif
                    </td>
                </tr>
            @empty
                <tr class="max-md:block"><td colspan="6" class="max-md:block px-5 py-16 text-center text-warm-gray"><x-icon name="clipboard" class="w-10 h-10 mx-auto mb-2" />Belum ada riwayat pesanan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $orders->links() }}</div>
@endsection
