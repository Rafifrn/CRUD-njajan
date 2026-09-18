<div class="space-y-6">
    <div>
        <h1 class="text-4xl font-normal text-gray-800">Semua Pesanan</h1>
        <p class="text-base text-gray-600">Monitor semua order lintas tenant.</p>
    </div>

    <!-- Filter -->
    <div class="flex flex-col sm:flex-row gap-3">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kode / nama user..."
               class="flex-1 px-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent">
        <select wire:model.live="filterStatus" class="px-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent">
            <option value="semua">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="diproses">Diproses</option>
            <option value="selesai">Selesai</option>
            <option value="dibatalkan">Dibatalkan</option>
        </select>
        <select wire:model.live="filterTenant" class="px-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent">
            <option value="semua">Semua Tenant</option>
            @foreach ($tenants as $t)
                <option value="{{ $t->slug }}">{{ $t->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Tabel -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200/20 overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left bg-gray-900 text-white">
                    <th class="px-5 py-4 font-bold">Kode</th>
                    <th class="px-5 py-4 font-bold">User</th>
                    <th class="px-5 py-4 font-bold">Tenant</th>
                    <th class="px-5 py-4 font-bold">Total</th>
                    <th class="px-5 py-4 font-bold">Bayar</th>
                    <th class="px-5 py-4 font-bold">Status</th>
                    <th class="px-5 py-4 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="border-t border-gray-200/20 hover:bg-green-50/20 transition">
                        <td class="px-5 py-4">
                            <p class="font-bold text-gray-800">{{ $order->kode }}</p>
                            <p class="text-xs text-gray-600">{{ $order->order_date->translatedFormat('d M H:i') }}</p>
                        </td>
                        <td class="px-5 py-4 text-gray-800">{{ $order->user->name }}</td>
                        <td class="px-5 py-4 text-gray-800">{{ $order->tenant->name ?? '-' }}</td>
                        <td class="px-5 py-4 font-bold text-gray-900">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-5 py-4">
                            @if ($order->payment_status === 'paid')
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-400 text-gray-900">Lunas</span>
                            @else
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-gray-800">Belum</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <select wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                                    class="px-3 py-1 border border-gray-200 rounded-md text-xs font-medium focus:outline-none focus:ring-2 focus:ring-deep-forest">
                                @foreach (['pending', 'diproses', 'selesai', 'dibatalkan'] as $s)
                                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-5 py-4 text-right">
                            @if ($order->payment_status === 'paid' && $order->payment_group)
                                <a href="{{ route('struk', $order->payment_group) }}" class="text-gray-900 hover:text-gray-900/80 font-bold text-xs">Struk</a>
                            @else
                                <span class="text-gray-600 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-5 py-12 text-center text-gray-600">Tidak ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $orders->links() }}
    </div>
</div>
