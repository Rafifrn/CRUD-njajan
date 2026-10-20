<div wire:poll.15s.visible class="space-y-6">
    <div>
        <h1 class="page-title">Produk — {{ $tenant->name }}</h1>
        <p class="page-sub">Kelola makanan, jajanan, dan minuman tenant kamu.</p>
    </div>

    <!-- Filter -->
    <div class="flex flex-wrap gap-2">
        @foreach (['semua' => 'Semua', 'makanan' => 'Makanan', 'jajanan' => 'Jajanan', 'minuman' => 'Minuman'] as $key => $label)
            <button wire:click="setFilter('{{ $key }}')"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ $filter === $key ? 'bg-coffee-bean text-amber-50' : 'bg-white border border-warm-sand text-forest-shadow hover:border-warm-sand/300' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form -->
        <div class="card p-6 h-fit lg:sticky lg:top-28">
            <div class="flex items-center gap-3 mb-6">
                <span class="grid place-items-center w-10 h-10 rounded-full bg-sage-mist text-mauve-bark"><x-icon name="{{ $editId ? 'edit' : 'plus' }}" class="w-5 h-5" /></span>
                <h2 class="text-xl font-bold">{{ $editId ? 'Edit Menu' : 'Tambah Menu' }}</h2>
            </div>

            <form wire:submit="save" class="space-y-5">
                <fieldset>
                    <legend class="block text-sm font-semibold mb-2">Tipe</legend>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="cursor-pointer"><input type="radio" wire:model.live="formType" value="makanan" class="peer sr-only"><span class="block text-center rounded-lg border border-warm-sand py-2.5 text-sm font-semibold text-warm-gray transition peer-checked:border-coffee-bean peer-checked:bg-coffee-bean peer-checked:text-amber-50 peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2">Makanan / Jajanan</span></label>
                        <label class="cursor-pointer"><input type="radio" wire:model.live="formType" value="minuman" class="peer sr-only"><span class="block text-center rounded-lg border border-warm-sand py-2.5 text-sm font-semibold text-warm-gray transition peer-checked:border-coffee-bean peer-checked:bg-coffee-bean peer-checked:text-amber-50 peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2">Minuman</span></label>
                    </div>
                </fieldset>

                @if ($formType === 'makanan')
                    <fieldset>
                        <legend class="block text-sm font-semibold mb-2">Kategori</legend>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="cursor-pointer"><input type="radio" wire:model.live="formCategory" value="makanan" class="peer sr-only"><span class="block text-center rounded-lg border border-warm-sand py-2.5 text-sm font-semibold text-warm-gray transition peer-checked:border-coffee-bean peer-checked:bg-coffee-bean peer-checked:text-amber-50 peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2">Makanan</span></label>
                            <label class="cursor-pointer"><input type="radio" wire:model.live="formCategory" value="jajanan" class="peer sr-only"><span class="block text-center rounded-lg border border-warm-sand py-2.5 text-sm font-semibold text-warm-gray transition peer-checked:border-coffee-bean peer-checked:bg-coffee-bean peer-checked:text-amber-50 peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2">Jajanan</span></label>
                        </div>
                    </fieldset>
                @endif

                <div>
                    <label for="p-name" class="block text-sm font-semibold mb-2">Nama</label>
                    <input id="p-name" type="text" wire:model="name" class="field w-full" placeholder="Contoh: Nasi Goreng">
                    @error('name') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="p-desc" class="block text-sm font-semibold mb-2">Deskripsi <span class="font-normal text-warm-gray">(opsional)</span></label>
                    <textarea id="p-desc" wire:model="description" rows="3" class="field w-full"></textarea>
                </div>

                <div>
                    <label for="p-price" class="block text-sm font-semibold mb-2">Harga</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-warm-gray">Rp</span>
                        <input id="p-price" type="number" wire:model="price" min="0" step="500" class="field w-full pl-10" placeholder="0">
                    </div>
                    @error('price') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <span class="block text-sm font-semibold mb-2">Foto</span>
                    @php $preview = $image ? $image->temporaryUrl() : ($existingImage ? (str_starts_with($existingImage, 'http') ? $existingImage : asset('storage/'.$existingImage)) : null); @endphp
                    <label class="relative block aspect-square rounded-[14px] border-2 border-dashed border-warm-sand bg-sage-mist/40 overflow-hidden cursor-pointer transition hover:border-mauve-bark focus-within:border-mauve-bark">
                        @if ($preview)
                            <img src="{{ $preview }}" alt="Pratinjau" class="absolute inset-0 w-full h-full object-cover">
                            <span class="absolute bottom-3 left-1/2 -translate-x-1/2 badge bg-white/90 backdrop-blur text-coffee-bean">Ganti foto</span>
                        @else
                            <span class="absolute inset-0 flex flex-col items-center justify-center gap-2 text-warm-gray text-center px-6">
                                <x-icon name="image" class="w-8 h-8" />
                                <span class="text-sm font-semibold text-coffee-bean">Pilih foto</span>
                                <span class="text-xs">Otomatis dipotong 1:1 &amp; dikompres. Maks. 10 MB.</span>
                            </span>
                        @endif
                        <input type="file" wire:model="image" accept="image/*" class="sr-only">
                        <span wire:loading wire:target="image" class="absolute inset-0 grid place-items-center bg-white/70 text-sm font-semibold">Mengunggah…</span>
                    </label>
                    @error('image') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <label class="flex items-center justify-between gap-3 cursor-pointer">
                    <span class="text-sm font-semibold">Tersedia dijual</span>
                    <input type="checkbox" wire:model="isAvailable" role="switch" class="peer sr-only">
                    <span class="relative w-12 h-7 rounded-full bg-warm-sand transition peer-checked:bg-coffee-bean peer-focus-visible:outline peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 after:content-[''] after:absolute after:top-1 after:left-1 after:w-5 after:h-5 after:rounded-full after:bg-white after:transition-transform peer-checked:after:translate-x-5"></span>
                </label>

                <div class="flex gap-2 pt-1">
                    <button type="submit" class="btn btn-dark flex-1" wire:loading.attr="disabled" wire:target="save,image">
                        {{ $editId ? 'Simpan Perubahan' : 'Tambah Menu' }}
                    </button>
                    @if ($editId)
                        <button type="button" wire:click="resetForm" class="btn btn-soft">Batal</button>
                    @endif
                </div>
            </form>
        </div>

        <!-- List -->
        <div class="lg:col-span-2 space-y-6">
            @if (in_array($filter, ['semua', 'makanan', 'jajanan']) && $makanans->count())
                <div class="card overflow-hidden">
                    <div class="px-5 py-3 bg-sage-mist/50 border-b border-warm-sand/40 font-bold text-forest-shadow">
                        Makanan & Jajanan
                    </div>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-warm-gray border-b border-warm-sand/40">
                                <th class="px-4 py-2">Produk</th>
                                <th class="px-4 py-2">Kategori</th>
                                <th class="px-4 py-2">Harga</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($makanans as $p)
                                <tr class="border-t border-warm-sand/30 {{ $editId === $p->id ? 'bg-amber-50' : '' }}">
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-2">
                                            @if ($p->image)
                                                <img src="{{ str_starts_with($p->image, 'http') ? $p->image : asset('storage/'.$p->image) }}" class="w-10 h-10 rounded object-cover" alt="">
                                            @endif
                                            <div>
                                                <p class="font-semibold text-forest-shadow">{{ $p->name }}</p>
                                                <p class="text-xs text-warm-gray line-clamp-1">{{ $p->description }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $p->category === 'jajanan' ? 'bg-amber-200 text-coffee-bean' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($p->category) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-forest-shadow">Rp{{ number_format($p->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">
                                        <button wire:click="toggleAvailableMakanan({{ $p->id }})"
                                                class="px-2 py-1 text-xs font-semibold rounded-full {{ $p->is_available ? 'bg-lime-glow/60 text-coffee-bean' : 'bg-gray-100 text-warm-gray' }}">
                                            {{ $p->is_available ? 'Tersedia' : 'Kosong' }}
                                        </button>
                                    </td>
                                    <td class="px-4 py-2 text-right space-x-1">
                                        <button wire:click="editMakanan({{ $p->id }})" class="text-mauve-bark hover:underline font-semibold text-xs">Edit</button>
                                        <button wire:click="deleteMakanan({{ $p->id }})" wire:confirm="Hapus {{ $p->name }}?" class="text-red-700 hover:text-red-900 font-semibold text-xs">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if (in_array($filter, ['semua', 'minuman']) && $minumans->count())
                <div class="card overflow-hidden">
                    <div class="px-5 py-3 bg-sage-mist/50 border-b border-warm-sand/40 font-bold text-forest-shadow">
                        Minuman
                    </div>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-warm-gray border-b border-warm-sand/40">
                                <th class="px-4 py-2">Produk</th>
                                <th class="px-4 py-2">Harga</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($minumans as $p)
                                <tr class="border-t border-warm-sand/30 {{ $editId === $p->id ? 'bg-amber-50' : '' }}">
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-2">
                                            @if ($p->image)
                                                <img src="{{ str_starts_with($p->image, 'http') ? $p->image : asset('storage/'.$p->image) }}" class="w-10 h-10 rounded object-cover" alt="">
                                            @endif
                                            <div>
                                                <p class="font-semibold text-forest-shadow">{{ $p->name }}</p>
                                                <p class="text-xs text-warm-gray line-clamp-1">{{ $p->description }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-forest-shadow">Rp{{ number_format($p->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">
                                        <button wire:click="toggleAvailableMinuman({{ $p->id }})"
                                                class="px-2 py-1 text-xs font-semibold rounded-full {{ $p->is_available ? 'bg-lime-glow/60 text-coffee-bean' : 'bg-gray-100 text-warm-gray' }}">
                                            {{ $p->is_available ? 'Tersedia' : 'Kosong' }}
                                        </button>
                                    </td>
                                    <td class="px-4 py-2 text-right space-x-1">
                                        <button wire:click="editMinuman({{ $p->id }})" class="text-mauve-bark hover:underline font-semibold text-xs">Edit</button>
                                        <button wire:click="deleteMinuman({{ $p->id }})" wire:confirm="Hapus {{ $p->name }}?" class="text-red-700 hover:text-red-900 font-semibold text-xs">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($makanans->isEmpty() && $minumans->isEmpty())
                <div class="text-center py-12 text-warm-gray card">
                    
                    <p>Belum ada produk pada filter ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
