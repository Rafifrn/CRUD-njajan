<?php

namespace App\Livewire;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class AdminUsers extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterRole = 'semua';

    // Form tambah user/tenant/admin
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'user';
    public ?int $tenantId = null;

    protected function rules(): array
    {
        return [
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:user,tenant,admin',
            'tenantId' => 'required_if:role,tenant|nullable|exists:tenants,id',
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterRole(): void
    {
        $this->resetPage();
    }

    public function updatedRole(string $value): void
    {
        if ($value !== 'tenant') {
            $this->tenantId = null;
        }
    }

    public function save(): void
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'tenant_id' => $this->role === 'tenant' ? $this->tenantId : null,
        ]);

        $this->reset(['name', 'email', 'password', 'role', 'tenantId']);
        $this->role = 'user';
    }

    public function delete(int $id): void
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return; // tidak bisa hapus diri sendiri
        }
        $user->delete();
    }

    #[Computed]
    public function tenants()
    {
        return Tenant::orderBy('name')->get();
    }

    public function render()
    {
        $users = User::with('tenant')
            ->when($this->search, fn ($q) => $q->where(fn ($q) => $q
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")))
            ->when($this->filterRole !== 'semua', fn ($q) => $q->where('role', $this->filterRole))
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('livewire.admin-users', ['users' => $users]);
    }
}
