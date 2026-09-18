<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk {{ $payment->group_code }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            body * { visibility: hidden; }
            #struk, #struk * { visibility: visible; }
            #struk { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-amber-50 flex items-start justify-center py-8">
    <div class="w-full max-w-sm">
        <div class="no-print mb-4 flex gap-3 justify-center">
            <button onclick="window.print()" class="px-6 py-3 rounded-full bg-mauve-bark hover:bg-dark-coffee text-amber-50 font-bold transition-colors">
                Cetak / Simpan PDF
            </button>
            <a href="javascript:history.back()" class="px-6 py-3 rounded-full bg-amber-100 hover:bg-amber-200 text-gray-900 font-bold transition-colors">Tutup</a>
        </div>

        <div id="struk" class="bg-white shadow-lg rounded-xl p-6 mx-auto border border-warm-gray/20" style="max-width: 380px;">
            <div class="text-center border-b border-dashed border-gray-300 pb-4 mb-4">
                <h1 class="text-2xl font-bold text-gray-900">NJAJAN</h1>
                <p class="text-xs text-gray-600">Aplikasi Pemesanan UMKM Nusantara</p>
            </div>

            <div class="text-xs text-forest-shadow space-y-1 mb-4">
                <div class="flex justify-between">
                    <span class="text-warm-gray">No. Struk</span>
                    <span class="font-bold">{{ $payment->group_code }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-warm-gray">Tanggal</span>
                    <span>{{ optional($payment->paid_at ?? $payment->created_at)->translatedFormat('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-warm-gray">Pelanggan</span>
                    <span>{{ optional($payment->orders->first()->user)->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-warm-gray">Metode</span>
                    <span>{{ strtoupper($payment->method ?? 'Xendit') }}</span>
                </div>
            </div>

            @foreach ($payment->orders as $order)
                <div class="border-t border-dashed border-warm-gray pt-3 mt-3">
                    <p class="font-bold text-sm text-deep-forest mb-2">{{ $order->tenant->name ?? 'Tanpa tenant' }}</p>
                    <p class="text-xs text-warm-gray mb-2">Order: {{ $order->kode }} · Status: {{ ucfirst($order->status) }}</p>
                    <div class="space-y-1">
                        @foreach ($order->orderItems as $item)
                            <div class="flex justify-between text-sm text-forest-shadow">
                                <span>{{ $item->qty }}× {{ $item->name }}</span>
                                <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        <div class="flex justify-between text-sm font-bold text-deep-forest pt-1 border-t border-warm-gray/20">
                            <span>Subtotal</span>
                            <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="border-t border-dashed border-warm-gray mt-4 pt-3 flex justify-between text-lg font-bold text-deep-forest">
                <span>TOTAL</span>
                <span>Rp{{ number_format($payment->amount, 0, ',', '.') }}</span>
            </div>

            <div class="text-center text-xs text-warm-gray border-t border-dashed border-warm-gray mt-4 pt-4">
                <p class="font-bold mb-1 text-forest-shadow">Status Pembayaran: {{ strtoupper($payment->status) }}</p>
                <p>Terima kasih sudah memesan di Njajan!</p>
                <p>Njajan Nusantara © {{ date('Y') }}</p>
            </div>
        </div>
    </div>
</body>
</html>
