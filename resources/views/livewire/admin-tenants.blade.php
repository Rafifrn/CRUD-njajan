<div wire:poll.15s.visible class="space-y-6">
    <div>
        <h1 class="page-title">Kelola Tenant</h1>
        <p class="page-sub">CRUD tenant UMKM.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form -->
        <div class="card p-6 h-fit">
            <h2 class="font-bold text-forest-shadow text-lg mb-4">{{ $editId ? 'Edit Tenant' : 'Tambah Tenant' }}</h2>
            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-forest-shadow mb-2">Nama</label>
                    <input type="text" wire:model="name" class="field w-full">
                    @error('name') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-forest-shadow mb-2">Deskripsi</label>
                    <textarea wire:model="description" rows="2" class="field w-full"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-forest-shadow mb-2">Logo <span class="font-normal text-warm-gray">(maks. 10 MB, otomatis dipotong 1:1 &amp; dikompres)</span></label>
                    @if ($existingLogo)
                        <img src="{{ asset('storage/'.$existingLogo) }}" class="w-full h-24 object-cover rounded-lg mb-2" alt="">
                    @endif
                    <input type="file" wire:model="logo" accept="image/*" class="w-full text-sm text-forest-shadow">
                    @error('logo') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <label class="flex items-center gap-2 text-sm text-forest-shadow">
                    <input type="checkbox" wire:model="isActive" class="rounded border-warm-sand"> Aktif
                </label>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 rounded-full bg-lime-glow hover:bg-amber-400 text-coffee-bean font-bold transition">
                        {{ $editId ? 'Simpan' : 'Tambah' }}
                    </button>
                    @if ($editId)
                        <button type="button" wire:click="resetForm" class="min-h-11 px-4 py-2 rounded-full bg-sage-mist hover:bg-warm-sand text-deep-forest font-bold transition">Batal</button>
                    @endif
                </div>
            </form>
        </div>

        <!-- List -->
        <div class="lg:col-span-2 card overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="table-head text-left">
                        <th class="px-5 py-4 font-bold">Tenant</th>
                        <th class="px-5 py-4 font-bold">Produk</th>
                        <th class="px-5 py-4 font-bold">Order</th>
                        <th class="px-5 py-4 font-bold">Status</th>
                        <th class="px-5 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tenants as $t)
                        <tr class="border-t border-warm-sand/60 hover:bg-sage-mist/40 transition {{ $editId === $t->id ? 'bg-lime-glow/20' : '' }}">
                            <td class="px-5 py-4">
                                <p class="font-bold text-forest-shadow">{{ $t->name }}</p>
                                <p class="text-xs text-warm-gray line-clamp-1">{{ $t->description }}</p>
                            </td>
                            <td class="px-5 py-4 text-forest-shadow">{{ $t->makanans_count + $t->minumen_count }}</td>
                            <td class="px-5 py-4 text-forest-shadow">{{ $t->orders_count }}</td>
                            <td class="px-5 py-4">
                                <button wire:click="toggleActive({{ $t->id }})"
                                        class="px-3 py-1 text-xs font-bold rounded-full {{ $t->is_active ? 'bg-lime-glow text-coffee-bean' : 'bg-warm-sand text-warm-gray' }}">
                                    {{ $t->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </td>
                            <td class="px-5 py-4 text-right space-x-2">
                                <button wire:click="edit({{ $t->id }})" class="text-forest-shadow hover:text-forest-shadow/80 font-bold text-xs">Edit</button>
                                <button wire:click="delete({{ $t->id }})" wire:confirm="Hapus tenant {{ $t->name }}?" class="text-red-700 hover:text-red-900 font-bold text-xs">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-warm-gray">Belum ada tenant.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
