<div wire:poll.5s.visible class="space-y-8">
    <div>
        <h1 class="page-title">Dashboard Admin</h1>
        <p class="page-sub">Ringkasan aktivitas aplikasi Njajan.</p>
    </div>

    <!-- Stat cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card p-6">
            <p class="text-xs text-warm-gray font-bold uppercase tracking-wide">Total Order</p>
            <p class="text-4xl font-bold text-forest-shadow mt-2">{{ $stats['totalOrder'] }}</p>
            <p class="text-sm text-warm-gray mt-2">{{ $stats['orderHariIni'] }} hari ini</p>
        </div>
        <div class="card p-6">
            <p class="text-xs text-warm-gray font-bold uppercase tracking-wide">Order Aktif</p>
            <p class="text-4xl font-bold text-forest-shadow mt-2">{{ $stats['orderPending'] + $stats['orderDiproses'] }}</p>
            <p class="text-sm text-warm-gray mt-2">{{ $stats['orderPending'] }} pending · {{ $stats['orderDiproses'] }} diproses</p>
        </div>
        <div class="card p-6">
            <p class="text-xs text-warm-gray font-bold uppercase tracking-wide">Keuntungan</p>
            <p class="text-3xl font-bold text-forest-shadow mt-2">Rp{{ number_format($stats['keuntungan'], 0, ',', '.') }}</p>
            <p class="text-sm text-warm-gray mt-2">Omzet hari ini: Rp{{ number_format($stats['omzetHariIni'], 0, ',', '.') }}</p>
        </div>
        <div class="card p-6">
            <p class="text-xs text-warm-gray font-bold uppercase tracking-wide">Tenant</p>
            <p class="text-4xl font-bold text-forest-shadow mt-2">{{ $stats['totalTenant'] }}</p>
            <p class="text-sm text-warm-gray mt-2">{{ $stats['totalProduk'] }} produk total</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top tenant -->
        <div class="card overflow-hidden">
            <div class="px-6 py-4 bg-sage-mist/60 border-b border-warm-sand/60 font-bold text-forest-shadow">
                <x-icon name="trophy" class="inline w-5 h-5 text-mauve-bark -mt-1" /> Tenant Teratas (omzet selesai)
            </div>
            <table class="w-full text-sm">
                <tbody>
                    @forelse ($topTenants as $tenant)
                        <tr class="border-t border-warm-sand/40 hover:bg-sage-mist/40 transition">
                            <td class="px-5 py-4 font-bold text-forest-shadow">{{ $tenant->name }}</td>
                            <td class="px-5 py-4 text-right font-bold text-forest-shadow">
                                Rp{{ number_format($tenant->orders_sum_total ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="px-5 py-8 text-center text-warm-gray">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Order terbaru -->
        <div class="card overflow-hidden">
            <div class="px-6 py-4 bg-sage-mist/60 border-b border-warm-sand/60 font-bold text-forest-shadow">
                <x-icon name="clock" class="inline w-5 h-5 text-mauve-bark -mt-1" /> Order Terbaru
            </div>
            <table class="w-full text-sm">
                <tbody>
                    @forelse ($orderTerbaru as $order)
                        <tr class="border-t border-warm-sand/40 hover:bg-sage-mist/40 transition">
                            <td class="px-5 py-4">
                                <p class="font-bold text-forest-shadow">{{ $order->kode }}</p>
                                <p class="text-xs text-warm-gray">{{ $order->user->name }} · {{ $order->tenant->name ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <p class="font-bold text-forest-shadow">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                                <p class="text-xs font-bold {{ $order->status === 'selesai' ? 'text-forest-shadow' : ($order->status === 'dibatalkan' ? 'text-red-700' : 'text-warm-gray') }}">{{ ucfirst($order->status) }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="px-5 py-8 text-center text-warm-gray">Belum ada order.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
