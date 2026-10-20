<div wire:poll.5s.visible class="space-y-6">
    <div>
        <h1 class="page-title">Semua Pesanan</h1>
        <p class="page-sub">Monitor semua order lintas tenant.</p>
    </div>

    <!-- Filter -->
    <div class="flex flex-col sm:flex-row gap-3">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kode / nama user..."
               class="field flex-1">
        <select wire:model.live="filterStatus" class="field">
            <option value="semua">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="diproses">Diproses</option>
            <option value="selesai">Selesai</option>
            <option value="dibatalkan">Dibatalkan</option>
        </select>
        <select wire:model.live="filterTenant" class="field">
            <option value="semua">Semua Tenant</option>
            @foreach ($tenants as $t)
                <option value="{{ $t->slug }}">{{ $t->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Tabel -->
    <div class="card overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="table-head text-left">
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
                    <tr class="border-t border-warm-sand/60 hover:bg-sage-mist/40 transition">
                        <td class="px-5 py-4">
                            <p class="font-bold text-forest-shadow">{{ $order->kode }}</p>
                            <p class="text-xs text-warm-gray">{{ $order->order_date->translatedFormat('d M H:i') }}</p>
                        </td>
                        <td class="px-5 py-4 text-forest-shadow">{{ $order->user->name }}</td>
                        <td class="px-5 py-4 text-forest-shadow">{{ $order->tenant->name ?? '-' }}</td>
                        <td class="px-5 py-4 font-bold text-forest-shadow">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-5 py-4">
                            @if ($order->payment_status === 'paid')
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-lime-glow text-coffee-bean">Lunas</span>
                            @else
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-200 text-coffee-bean">Belum</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <select wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                                    class="field !py-1.5 text-xs">
                                @foreach (['pending', 'diproses', 'selesai', 'dibatalkan'] as $s)
                                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-5 py-4 text-right">
                            @if ($order->payment_status === 'paid' && $order->payment_group)
                                <a href="{{ route('struk', $order->payment_group) }}" class="text-forest-shadow hover:text-forest-shadow/80 font-bold text-xs">Struk</a>
                            @else
                                <span class="text-warm-gray text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-5 py-12 text-center text-warm-gray">Tidak ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $orders->links() }}
    </div>
</div>
