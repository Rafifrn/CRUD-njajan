<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Produk — {{ $tenant->name }}</h1>
        <p class="text-sm text-gray-600">Kelola makanan, jajanan, dan minuman tenant kamu.</p>
    </div>

    <!-- Filter -->
    <div class="flex flex-wrap gap-2">
        @foreach (['semua' => 'Semua', 'makanan' => 'Makanan', 'jajanan' => 'Jajanan', 'minuman' => 'Minuman'] as $key => $label)
            <button wire:click="setFilter('{{ $key }}')"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ $filter === $key ? 'bg-[#212529] text-white' : 'bg-white border border-gray-300 text-gray-700 hover:border-gray-500' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 h-fit">
            <h2 class="font-bold text-gray-800 mb-4">{{ $editId ? 'Edit Produk' : 'Tambah Produk' }}</h2>

            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe Produk</label>
                    <select wire:model.live="formType" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        <option value="makanan">Makanan / Jajanan</option>
                        <option value="minuman">Minuman</option>
                    </select>
                </div>

                @if ($formType === 'makanan')
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                        <select wire:model.live="formCategory" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="makanan">Makanan</option>
                            <option value="jajanan">Jajanan</option>
                        </select>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
                    <input type="text" wire:model="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Contoh: Nasi Goreng">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                    <textarea wire:model="description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" wire:model="price" min="0" step="500" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar</label>
                    @if ($existingImage)
                        <img src="{{ $existingImage }}" class="w-full h-32 object-cover rounded-lg mb-2" alt="preview">
                    @endif
                    <input type="file" wire:model="image" accept="image/*" class="w-full text-sm">
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" wire:model="isAvailable" class="rounded"> Tersedia dijual
                </label>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 rounded-lg bg-[#212529] hover:bg-black text-white text-sm font-semibold transition">
                        {{ $editId ? 'Simpan Perubahan' : 'Tambah' }}
                    </button>
                    @if ($editId)
                        <button type="button" wire:click="resetForm" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-semibold transition">
                            Batal
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <!-- List -->
        <div class="lg:col-span-2 space-y-6">
            @if (in_array($filter, ['semua', 'makanan', 'jajanan']) && $makanans->count())
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 font-bold text-gray-800">
                        Makanan & Jajanan
                    </div>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b border-gray-100">
                                <th class="px-4 py-2">Produk</th>
                                <th class="px-4 py-2">Kategori</th>
                                <th class="px-4 py-2">Harga</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($makanans as $p)
                                <tr class="border-t border-gray-50 {{ $editId === $p->id ? 'bg-amber-50' : '' }}">
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-2">
                                            @if ($p->image)
                                                <img src="{{ $p->image }}" class="w-10 h-10 rounded object-cover" alt="">
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $p->name }}</p>
                                                <p class="text-xs text-gray-500 line-clamp-1">{{ $p->description }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $p->category === 'jajanan' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700' }}">
                                            {{ ucfirst($p->category) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-gray-800">Rp{{ number_format($p->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">
                                        <button wire:click="toggleAvailableMakanan({{ $p->id }})"
                                                class="px-2 py-1 text-xs font-semibold rounded-full {{ $p->is_available ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $p->is_available ? 'Tersedia' : 'Kosong' }}
                                        </button>
                                    </td>
                                    <td class="px-4 py-2 text-right space-x-1">
                                        <button wire:click="editMakanan({{ $p->id }})" class="text-blue-600 hover:text-blue-800 font-semibold text-xs">Edit</button>
                                        <button wire:click="deleteMakanan({{ $p->id }})" wire:confirm="Hapus {{ $p->name }}?" class="text-red-500 hover:text-red-700 font-semibold text-xs">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if (in_array($filter, ['semua', 'minuman']) && $minumans->count())
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 font-bold text-gray-800">
                        🥤 Minuman
                    </div>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b border-gray-100">
                                <th class="px-4 py-2">Produk</th>
                                <th class="px-4 py-2">Harga</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($minumans as $p)
                                <tr class="border-t border-gray-50 {{ $editId === $p->id ? 'bg-amber-50' : '' }}">
                                    <td class="px-4 py-2">
                                        <div class="flex items-center gap-2">
                                            @if ($p->image)
                                                <img src="{{ $p->image }}" class="w-10 h-10 rounded object-cover" alt="">
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $p->name }}</p>
                                                <p class="text-xs text-gray-500 line-clamp-1">{{ $p->description }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-gray-800">Rp{{ number_format($p->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">
                                        <button wire:click="toggleAvailableMinuman({{ $p->id }})"
                                                class="px-2 py-1 text-xs font-semibold rounded-full {{ $p->is_available ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $p->is_available ? 'Tersedia' : 'Kosong' }}
                                        </button>
                                    </td>
                                    <td class="px-4 py-2 text-right space-x-1">
                                        <button wire:click="editMinuman({{ $p->id }})" class="text-blue-600 hover:text-blue-800 font-semibold text-xs">Edit</button>
                                        <button wire:click="deleteMinuman({{ $p->id }})" wire:confirm="Hapus {{ $p->name }}?" class="text-red-500 hover:text-red-700 font-semibold text-xs">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($makanans->isEmpty() && $minumans->isEmpty())
                <div class="text-center py-12 text-gray-500 bg-white rounded-xl border border-gray-200">
                    
                    <p>Belum ada produk pada filter ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
