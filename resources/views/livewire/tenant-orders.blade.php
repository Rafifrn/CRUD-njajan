<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-4xl font-normal text-gray-800">Pesanan — {{ $tenant->name }}</h1>
            <p class="text-base text-gray-600">Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</p>
        </div>
        <input type="date" wire:model.live="tanggal" class="px-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent">
    </div>

    <!-- Tab aktif / nonaktif -->
    <div class="flex gap-2">
        <button wire:click="setTab('aktif')"
                class="px-6 py-2 rounded-full text-sm font-bold transition {{ $tab === 'aktif' ? 'bg-green-400 text-gray-900' : 'bg-white border border-gray-200 text-gray-800 hover:border-deep-forest' }}">
            Aktif ({{ $ordersAktif->count() }})
        </button>
        <button wire:click="setTab('nonaktif')"
                class="px-6 py-2 rounded-full text-sm font-bold transition {{ $tab === 'nonaktif' ? 'bg-green-400 text-gray-900' : 'bg-white border border-gray-200 text-gray-800 hover:border-deep-forest' }}">
            Selesai / Batal ({{ $ordersNonaktif->count() }})
        </button>
    </div>

    @if ($tab === 'aktif')
        @forelse ($ordersAktif as $order)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/20 overflow-hidden">
                <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-200/20 bg-green-50/30">
                    <div>
                        <span class="font-bold text-gray-800 text-lg">{{ $order->kode }}</span>
                        <span class="text-gray-600 mx-2">•</span>
                        <span class="text-gray-800">{{ $order->user->name }}</span>
                        <span class="text-gray-600 mx-2">•</span>
                        <span class="text-xs text-gray-600">{{ $order->order_date->translatedFormat('H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($order->payment_status === 'paid')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-400 text-gray-900">Lunas</span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-gray-800">Belum Bayar</span>
                        @endif
                        @if ($order->status === 'pending')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-50 text-gray-900">Menunggu</span>
                        @elseif ($order->status === 'diproses')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-gray-800">Diproses</span>
                        @endif
                    </div>
                </div>
                <div class="px-6 py-5">
                    <ul class="space-y-2 text-sm text-gray-800">
                        @foreach ($order->orderItems as $item)
                            <li class="flex justify-between py-2 border-b border-gray-200/10 last:border-0">
                                <span class="font-medium">{{ $item->qty }}× {{ $item->name }}</span>
                                <span class="font-bold">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="flex justify-between font-bold text-gray-900 text-lg mt-4 pt-4 border-t border-gray-200/20">
                        <span>Total</span>
                        <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-5">
                        @if ($order->status === 'pending')
                            <button wire:click="updateStatus({{ $order->id }}, 'diproses')"
                                    class="px-5 py-2 rounded-full bg-amber-100 hover:bg-amber-100/80 text-gray-800 font-bold transition">
                                Proses Pesanan
                            </button>
                        @endif
                        <button wire:click="updateStatus({{ $order->id }}, 'selesai')"
                                class="px-5 py-2 rounded-full bg-green-400 hover:bg-green-400/90 text-gray-900 font-bold transition">
                            Selesai
                        </button>
                        <button wire:click="updateStatus({{ $order->id }}, 'dibatalkan')"
                                class="px-5 py-2 rounded-full bg-red-600 hover:bg-red-700 text-white font-bold transition">
                            Batalkan
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white rounded-xl border border-gray-200/20">
                <p class="text-6xl mb-4">📭</p>
                <p class="text-lg text-gray-600">Tidak ada pesanan aktif hari ini.</p>
            </div>
        @endforelse
    @else
        @forelse ($ordersNonaktif as $order)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/20 overflow-hidden opacity-70">
                <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-200/20">
                    <div>
                        <span class="font-bold text-gray-800">{{ $order->kode }}</span>
                        <span class="text-gray-600 mx-2">•</span>
                        <span class="text-gray-800">{{ $order->user->name }}</span>
                        <span class="text-gray-600 mx-2">•</span>
                        <span class="text-xs text-gray-600">{{ $order->order_date->translatedFormat('H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($order->status === 'selesai')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-400 text-gray-900">Selesai</span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">Dibatalkan</span>
                        @endif
                    </div>
                </div>
                <div class="px-6 py-5">
                    <ul class="space-y-1 text-sm text-gray-800">
                        @foreach ($order->orderItems as $item)
                            <li class="flex justify-between">
                                <span>{{ $item->qty }}× {{ $item->name }}</span>
                                <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="flex justify-between font-bold text-gray-900 mt-3 pt-3 border-t border-gray-200/20">
                        <span>Total</span>
                        <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white rounded-xl border border-gray-200/20">
                
                <p class="text-lg text-gray-600">Belum ada pesanan selesai hari ini.</p>
            </div>
        @endforelse
    @endif
</div>
