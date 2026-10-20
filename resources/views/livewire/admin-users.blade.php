<div class="space-y-6">
    <div>
        <h1 class="page-title">Kelola User</h1>
        <p class="page-sub">User, tenant (kasir), dan admin.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form tambah -->
        <div class="card p-6 h-fit">
            <h2 class="font-bold text-forest-shadow text-lg mb-4">Tambah Akun</h2>
            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-forest-shadow mb-2">Nama</label>
                    <input type="text" wire:model="name" class="field w-full">
                    @error('name') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-forest-shadow mb-2">Email</label>
                    <input type="email" wire:model="email" class="field w-full">
                    @error('email') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-forest-shadow mb-2">Nomor HP</label>
                    <input type="text" wire:model="phone" placeholder="08xxxxxxxxxx" class="field w-full">
                    @error('phone') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-forest-shadow mb-2">Password</label>
                    <x-password-toggle><input type="password" wire:model="password" class="w-full pl-4 pr-16 py-2 border border-warm-sand rounded-md focus:outline-none focus:ring-2 focus:ring-deep-forest focus:border-transparent"></x-password-toggle>
                    @error('password') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-forest-shadow mb-2">Role</label>
                    <select wire:model.live="role" class="field w-full">
                        <option value="user">User (Pelanggan)</option>
                        <option value="tenant">Tenant (Kasir)</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                @if ($role === 'tenant')
                    <div>
                        <label class="block text-sm font-bold text-forest-shadow mb-2">Tenant</label>
                        <select wire:model="tenantId" class="field w-full">
                            <option value="">— Pilih tenant —</option>
                            @foreach ($tenants as $t)
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                        @error('tenantId') <p class="text-red-700 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif
                <button type="submit" class="w-full px-4 py-2 rounded-full bg-lime-glow hover:bg-amber-400 text-coffee-bean font-bold transition">
                    Tambah Akun
                </button>
            </form>
        </div>

        <!-- List -->
        <div class="lg:col-span-2 space-y-3">
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama / no. HP..."
                       class="field flex-1">
                <select wire:model.live="filterRole" class="field">
                    <option value="semua">Semua Role</option>
                    <option value="user">User</option>
                    <option value="tenant">Tenant</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="card overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="table-head text-left">
                            <th class="px-5 py-4 font-bold">Nama</th>
                            <th class="px-5 py-4 font-bold">No. HP</th>
                            <th class="px-5 py-4 font-bold">Role</th>
                            <th class="px-5 py-4 font-bold">Tenant</th>
                            <th class="px-5 py-4 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $u)
                            <tr class="border-t border-warm-sand/60 hover:bg-sage-mist/40 transition">
                                <td class="px-5 py-4 font-bold text-forest-shadow">{{ $u->name }}</td>
                                <td class="px-5 py-4 text-warm-gray">{{ $u->phone ?? '-' }}</td>
                                <td class="px-5 py-4">
                                    <span class="px-3 py-1 text-xs font-bold rounded-full {{ $u->role === 'admin' ? 'bg-coffee-bean text-amber-50' : ($u->role === 'tenant' ? 'bg-amber-200 text-coffee-bean' : 'bg-sage-mist text-deep-forest') }}">
                                        {{ ucfirst($u->role) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-forest-shadow">{{ $u->tenant->name ?? '-' }}</td>
                                <td class="px-5 py-4 text-right">
                                    @if ($u->id !== auth()->id())
                                        <button wire:click="delete({{ $u->id }})" wire:confirm="Hapus akun {{ $u->name }}?" class="text-red-700 hover:text-red-900 font-bold text-xs">Hapus</button>
                                    @else
                                        <span class="text-warm-gray text-xs">(Anda)</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-12 text-center text-warm-gray">Tidak ada user.</td></tr>
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
