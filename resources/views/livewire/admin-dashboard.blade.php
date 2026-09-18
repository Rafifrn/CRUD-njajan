<div class="space-y-8">
    <div>
        <h1 class="text-4xl font-normal text-gray-800">Dashboard Admin</h1>
        <p class="text-base text-gray-600">Ringkasan aktivitas aplikasi Njajan.</p>
    </div>

    <!-- Stat cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200/20 p-6">
            <p class="text-xs text-gray-600 font-bold uppercase tracking-wide">Total Order</p>
            <p class="text-4xl font-bold text-gray-900 mt-2">{{ $stats['totalOrder'] }}</p>
            <p class="text-sm text-gray-600 mt-2">{{ $stats['orderHariIni'] }} hari ini</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200/20 p-6">
            <p class="text-xs text-gray-600 font-bold uppercase tracking-wide">Order Aktif</p>
            <p class="text-4xl font-bold text-gray-900 mt-2">{{ $stats['orderPending'] + $stats['orderDiproses'] }}</p>
            <p class="text-sm text-gray-600 mt-2">{{ $stats['orderPending'] }} pending · {{ $stats['orderDiproses'] }} diproses</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200/20 p-6">
            <p class="text-xs text-gray-600 font-bold uppercase tracking-wide">Keuntungan</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">Rp{{ number_format($stats['keuntungan'], 0, ',', '.') }}</p>
            <p class="text-sm text-gray-600 mt-2">Omzet hari ini: Rp{{ number_format($stats['omzetHariIni'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200/20 p-6">
            <p class="text-xs text-gray-600 font-bold uppercase tracking-wide">Tenant</p>
            <p class="text-4xl font-bold text-gray-900 mt-2">{{ $stats['totalTenant'] }}</p>
            <p class="text-sm text-gray-600 mt-2">{{ $stats['totalProduk'] }} produk total</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top tenant -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200/20 overflow-hidden">
            <div class="px-6 py-4 bg-amber-50/30 border-b border-gray-200/20 font-bold text-gray-900">
                🏆 Tenant Teratas (omzet selesai)
            </div>
            <table class="w-full text-sm">
                <tbody>
                    @forelse ($topTenants as $tenant)
                        <tr class="border-t border-gray-200/10 hover:bg-amber-50/20 transition">
                            <td class="px-5 py-4 font-bold text-gray-800">{{ $tenant->name }}</td>
                            <td class="px-5 py-4 text-right font-bold text-gray-900">
                                Rp{{ number_format($tenant->orders_sum_total ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="px-5 py-8 text-center text-gray-600">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Order terbaru -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200/20 overflow-hidden">
            <div class="px-6 py-4 bg-amber-50/30 border-b border-gray-200/20 font-bold text-gray-900">
                🕒 Order Terbaru
            </div>
            <table class="w-full text-sm">
                <tbody>
                    @forelse ($orderTerbaru as $order)
                        <tr class="border-t border-gray-200/10 hover:bg-amber-50/20 transition">
                            <td class="px-5 py-4">
                                <p class="font-bold text-gray-800">{{ $order->kode }}</p>
                                <p class="text-xs text-gray-600">{{ $order->user->name }} · {{ $order->tenant->name ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <p class="font-bold text-gray-900">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                                <p class="text-xs font-bold {{ $order->status === 'selesai' ? 'text-gray-900' : ($order->status === 'dibatalkan' ? 'text-red-600' : 'text-gray-600') }}">{{ ucfirst($order->status) }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="px-5 py-8 text-center text-gray-600">Belum ada order.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
