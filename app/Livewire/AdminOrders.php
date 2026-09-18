<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class AdminOrders extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = 'semua';
    public string $filterTenant = 'semua';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatingFilterTenant(): void
    {
        $this->resetPage();
    }

    public function updateStatus(int $orderId, string $status): void
    {
        if (! in_array($status, ['pending', 'diproses', 'selesai', 'dibatalkan'])) {
            return;
        }
        Order::findOrFail($orderId)->update(['status' => $status]);
    }

    #[Computed]
    public function tenants()
    {
        return \App\Models\Tenant::orderBy('name')->get();
    }

    public function render()
    {
        $orders = Order::with(['user', 'tenant', 'orderItems'])
            ->when($this->search, function ($q) {
                $q->where('kode', 'like', "%{$this->search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$this->search}%"));
            })
            ->when($this->filterStatus !== 'semua', fn ($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterTenant !== 'semua', fn ($q) => $q->whereHas('tenant', fn ($t) => $t->where('slug', $this->filterTenant)))
            ->orderByDesc('order_date')
            ->paginate(15);

        return view('livewire.admin-orders', [
            'orders' => $orders,
            'tenants' => $this->tenants(),
        ]);
    }
}
