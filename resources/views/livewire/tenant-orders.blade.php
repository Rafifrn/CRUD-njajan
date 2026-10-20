<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div>
            <h1 class="page-title">Pesanan — {{ $tenant->name }}</h1>
            <p class="page-sub">Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</p>
        </div>
        <input type="date" wire:model.live="tanggal" class="field">
    </div>

    <!-- Tab aktif / nonaktif -->
    <div class="flex gap-2">
        <button wire:click="setTab('aktif')"
                class="px-6 py-2 rounded-full text-sm font-bold transition {{ $tab === 'aktif' ? 'bg-lime-glow text-coffee-bean' : 'bg-white border border-warm-sand text-forest-shadow hover:border-mauve-bark' }}">
            Aktif ({{ $ordersAktif->count() }})
        </button>
        <button wire:click="setTab('nonaktif')"
                class="px-6 py-2 rounded-full text-sm font-bold transition {{ $tab === 'nonaktif' ? 'bg-lime-glow text-coffee-bean' : 'bg-white border border-warm-sand text-forest-shadow hover:border-mauve-bark' }}">
            Selesai / Batal ({{ $ordersNonaktif->count() }})
        </button>
    </div>

    @if ($tab === 'aktif')
        @forelse ($ordersAktif as $order)
            <div class="card overflow-hidden">
                <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-warm-sand/60 bg-sage-mist/60">
                    <div>
                        <span class="font-bold text-forest-shadow text-lg">{{ $order->kode }}</span>
                        <span class="text-warm-gray mx-2">•</span>
                        <span class="text-forest-shadow">{{ $order->user->name }}</span>
                        <span class="text-warm-gray mx-2">•</span>
                        <span class="text-xs text-warm-gray">{{ $order->order_date->translatedFormat('H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($order->payment_status === 'paid')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-lime-glow text-coffee-bean">Lunas</span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-200 text-coffee-bean">Belum Bayar</span>
                        @endif
                        @if ($order->status === 'pending')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-sage-mist text-deep-forest">Menunggu</span>
                        @elseif ($order->status === 'diproses')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-200 text-coffee-bean">Diproses</span>
                        @endif
                    </div>
                </div>
                <div class="px-6 py-5">
                    <ul class="space-y-2 text-sm text-forest-shadow">
                        @foreach ($order->orderItems as $item)
                            <li class="flex justify-between py-2 border-b border-warm-sand/40 last:border-0">
                                <span class="font-medium">{{ $item->qty }}× {{ $item->name }}</span>
                                <span class="font-bold">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="flex justify-between font-bold text-forest-shadow text-lg mt-4 pt-4 border-t border-warm-sand/60">
                        <span>Total</span>
                        <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-5">
                        @if ($order->status === 'pending')
                            <button wire:click="updateStatus({{ $order->id }}, 'diproses')"
                                    class="px-5 py-2 rounded-full bg-amber-100 hover:bg-amber-100/80 text-forest-shadow font-bold transition">
                                Proses Pesanan
                            </button>
                        @endif
                        <button wire:click="updateStatus({{ $order->id }}, 'selesai')"
                                class="px-5 py-2 rounded-full bg-lime-glow hover:bg-amber-400 text-coffee-bean font-bold transition">
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
            <div class="text-center py-16 card">
                <x-icon name="inbox" class="w-12 h-12 mx-auto text-warm-gray mb-3" />
                <p class="text-lg text-warm-gray">Tidak ada pesanan aktif hari ini.</p>
            </div>
        @endforelse
    @else
        @forelse ($ordersNonaktif as $order)
            <div class="card overflow-hidden opacity-70">
                <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-warm-sand/60">
                    <div>
                        <span class="font-bold text-forest-shadow">{{ $order->kode }}</span>
                        <span class="text-warm-gray mx-2">•</span>
                        <span class="text-forest-shadow">{{ $order->user->name }}</span>
                        <span class="text-warm-gray mx-2">•</span>
                        <span class="text-xs text-warm-gray">{{ $order->order_date->translatedFormat('H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($order->status === 'selesai')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-lime-glow text-coffee-bean">Selesai</span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Dibatalkan</span>
                        @endif
                    </div>
                </div>
                <div class="px-6 py-5">
                    <ul class="space-y-1 text-sm text-forest-shadow">
                        @foreach ($order->orderItems as $item)
                            <li class="flex justify-between">
                                <span>{{ $item->qty }}× {{ $item->name }}</span>
                                <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="flex justify-between font-bold text-forest-shadow mt-3 pt-3 border-t border-warm-sand/60">
                        <span>Total</span>
                        <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 card">
                
                <p class="text-lg text-warm-gray">Belum ada pesanan selesai hari ini.</p>
            </div>
        @endforelse
    @endif
</div>
