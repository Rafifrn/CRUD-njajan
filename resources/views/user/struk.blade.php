<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
    <title>Struk {{ $payment->group_code }}</title>
    <style>@media print { body * { visibility: hidden; } #struk, #struk * { visibility: visible; } #struk { position: absolute; left: 0; top: 0; width: 100%; box-shadow: none; } .no-print { display: none !important; } }</style>
</head>
<body class="py-8 px-4">
<div class="max-w-sm mx-auto">
    <div class="no-print mb-4 flex gap-3 justify-center">
        <button onclick="window.print()" class="btn btn-dark">Cetak / Simpan PDF</button>
        <a href="{{ Auth::user()->isAdmin() ? route('admin.orders') : route('history') }}" class="btn btn-soft">Tutup</a>
    </div>
    <div id="struk" class="card p-6 text-sm">
        <div class="text-center border-b border-dashed border-warm-gray pb-4 mb-4">
            <p class="text-2xl font-bold">NJAJAN</p>
            <p class="text-xs text-warm-gray">Aplikasi Pemesanan UMKM Nusantara</p>
        </div>
        <dl class="text-xs space-y-1 mb-4">
            @foreach ([
                'No. Struk' => $payment->group_code,
                'Tanggal' => optional($payment->paid_at ?? $payment->created_at)->translatedFormat('d/m/Y H:i'),
                'Pelanggan' => optional($payment->orders->first()->user)->name ?? '-',
                'Metode' => strtoupper($payment->method ?? 'Xendit'),
            ] as $k => $v)
                <div class="flex justify-between"><dt class="text-warm-gray">{{ $k }}</dt><dd class="font-semibold">{{ $v }}</dd></div>
            @endforeach
        </dl>
        @foreach ($payment->orders as $order)
            <section class="border-t border-dashed border-warm-gray pt-3 mt-3">
                <p class="font-bold">{{ $order->tenant->name ?? 'Tanpa tenant' }}</p>
                <p class="text-xs text-warm-gray mb-2">{{ $order->kode }} · {{ ucfirst($order->status) }}</p>
                @foreach ($order->orderItems as $item)
                    <div class="flex justify-between"><span>{{ $item->qty }}× {{ $item->name }}</span><span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span></div>
                @endforeach
                <div class="flex justify-between font-bold pt-1 mt-1 border-t border-warm-sand"><span>Subtotal</span><span>Rp{{ number_format($order->total, 0, ',', '.') }}</span></div>
            </section>
        @endforeach
        <div class="border-t border-dashed border-warm-gray mt-4 pt-3 flex justify-between text-lg font-bold"><span>TOTAL</span><span>Rp{{ number_format($payment->amount, 0, ',', '.') }}</span></div>
        <div class="text-center text-xs text-warm-gray border-t border-dashed border-warm-gray mt-4 pt-4">
            <p class="font-bold text-forest-shadow mb-1">Status: {{ strtoupper($payment->status) }}</p>
            <p>Terima kasih sudah memesan di Njajan!</p>
        </div>
    </div>
</div>
</body>
</html>
