<div class="space-y-6">
    <div>
        <h1 class="text-4xl font-normal text-gray-800">Kelola Tenant</h1>
        <p class="text-base text-gray-600">CRUD tenant UMKM.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200/20 p-6 h-fit">
            <h2 class="font-bold text-gray-900 text-lg mb-4">{{ $editId ? 'Edit Tenant' : 'Tambah Tenant' }}</h2>
            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Nama</label>
                    <input type="text" wire:model="name" class="w-full px-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent">
                    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Deskripsi</label>
                    <textarea wire:model="description" rows="2" class="w-full px-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Logo</label>
                    @if ($existingLogo)
                        <img src="{{ $existingLogo }}" class="w-full h-24 object-cover rounded-lg mb-2" alt="">
                    @endif
                    <input type="file" wire:model="logo" accept="image/*" class="w-full text-sm text-gray-800">
                    @error('logo') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-800">
                    <input type="checkbox" wire:model="isActive" class="rounded border-gray-200"> Aktif
                </label>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 rounded-full bg-green-400 hover:bg-green-400/90 text-gray-900 font-bold transition">
                        {{ $editId ? 'Simpan' : 'Tambah' }}
                    </button>
                    @if ($editId)
                        <button type="button" wire:click="resetForm" class="px-4 py-2 rounded-full bg-green-50 hover:bg-green-50/80 text-gray-900 font-bold transition">Batal</button>
                    @endif
                </div>
            </form>
        </div>

        <!-- List -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200/20 overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left bg-gray-900 text-white">
                        <th class="px-5 py-4 font-bold">Tenant</th>
                        <th class="px-5 py-4 font-bold">Produk</th>
                        <th class="px-5 py-4 font-bold">Order</th>
                        <th class="px-5 py-4 font-bold">Status</th>
                        <th class="px-5 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tenants as $t)
                        <tr class="border-t border-gray-200/20 hover:bg-green-50/20 transition {{ $editId === $t->id ? 'bg-green-400/20' : '' }}">
                            <td class="px-5 py-4">
                                <p class="font-bold text-gray-800">{{ $t->name }}</p>
                                <p class="text-xs text-gray-600 line-clamp-1">{{ $t->description }}</p>
                            </td>
                            <td class="px-5 py-4 text-gray-800">{{ $t->makanans_count + $t->minumen_count }}</td>
                            <td class="px-5 py-4 text-gray-800">{{ $t->orders_count }}</td>
                            <td class="px-5 py-4">
                                <button wire:click="toggleActive({{ $t->id }})"
                                        class="px-3 py-1 text-xs font-bold rounded-full {{ $t->is_active ? 'bg-green-400 text-gray-900' : 'bg-warm-gray/20 text-gray-600' }}">
                                    {{ $t->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td class="px-5 py-4 text-right space-x-2">
                                <button wire:click="edit({{ $t->id }})" class="text-gray-900 hover:text-gray-900/80 font-bold text-xs">Edit</button>
                                <button wire:click="delete({{ $t->id }})" wire:confirm="Hapus tenant {{ $t->name }}?" class="text-red-600 hover:text-red-700 font-bold text-xs">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-gray-600">Belum ada tenant.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
