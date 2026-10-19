<div class="space-y-6">
    <div>
        <h1 class="text-4xl font-normal text-gray-800">Kelola User</h1>
        <p class="text-base text-gray-600">User, tenant (kasir), dan admin.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form tambah -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200/20 p-6 h-fit">
            <h2 class="font-bold text-gray-900 text-lg mb-4">Tambah Akun</h2>
            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Nama</label>
                    <input type="text" wire:model="name" class="w-full px-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent">
                    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Email</label>
                    <input type="email" wire:model="email" class="w-full px-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent">
                    @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Nomor HP</label>
                    <input type="text" wire:model="phone" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent">
                    @error('phone') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Password</label>
                    <x-password-toggle><input type="password" wire:model="password" class="w-full pl-4 pr-16 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent"></x-password-toggle>
                    @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-2">Role</label>
                    <select wire:model.live="role" class="w-full px-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent">
                        <option value="user">User (Pelanggan)</option>
                        <option value="tenant">Tenant (Kasir)</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                @if ($role === 'tenant')
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-2">Tenant</label>
                        <select wire:model="tenantId" class="w-full px-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent">
                            <option value="">— Pilih tenant —</option>
                            @foreach ($tenants as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                        @error('tenantId') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif
                <button type="submit" class="w-full px-4 py-2 rounded-full bg-green-400 hover:bg-green-400/90 text-gray-900 font-bold transition">
                    Tambah Akun
                </button>
            </form>
        </div>

        <!-- List -->
        <div class="lg:col-span-2 space-y-3">
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama / no. HP..."
                       class="flex-1 px-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent">
                <select wire:model.live="filterRole" class="px-4 py-2 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent">
                    <option value="semua">Semua Role</option>
                    <option value="user">User</option>
                    <option value="tenant">Tenant</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200/20 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left bg-gray-900 text-white">
                            <th class="px-5 py-4 font-bold">Nama</th>
                            <th class="px-5 py-4 font-bold">No. HP</th>
                            <th class="px-5 py-4 font-bold">Role</th>
                            <th class="px-5 py-4 font-bold">Tenant</th>
                            <th class="px-5 py-4 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $u)
                            <tr class="border-t border-gray-200/20 hover:bg-green-50/20 transition">
                                <td class="px-5 py-4 font-bold text-gray-800">{{ $u->name }}</td>
                                <td class="px-5 py-4 text-gray-600">{{ $u->phone ?? '-' }}</td>
                                <td class="px-5 py-4">
                                    <span class="px-3 py-1 text-xs font-bold rounded-full {{ $u->role === 'admin' ? 'bg-gray-900 text-white' : ($u->role === 'tenant' ? 'bg-amber-100 text-gray-800' : 'bg-green-50 text-gray-900') }}">
                                        {{ ucfirst($u->role) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-gray-800">{{ $u->tenant->name ?? '-' }}</td>
                                <td class="px-5 py-4 text-right">
                                    @if ($u->id !== auth()->id())
                                        <button wire:click="delete({{ $u->id }})" wire:confirm="Hapus akun {{ $u->name }}?" class="text-red-600 hover:text-red-700 font-bold text-xs">Hapus</button>
                                    @else
                                        <span class="text-gray-600 text-xs">(Anda)</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-12 text-center text-gray-600">Tidak ada user.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
