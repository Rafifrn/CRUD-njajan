<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class TenantOrders extends Component
{
    public string $tab = 'aktif'; // aktif | nonaktif
    public string $tanggal;

    public function mount()
    {
        $this->tanggal = now()->toDateString();
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
    }

    #[Computed]
    public function tenant()
    {
        return Auth::user()->tenant;
    }

    #[Computed]
    public function ordersAktif()
    {
        return Order::with(['user', 'orderItems'])
            ->where('tenant_id', $this->tenant->id)
            ->whereDate('order_date', $this->tanggal)
            ->whereIn('status', ['pending', 'diproses'])
            ->orderBy('order_date', 'asc')
            ->get();
    }

    #[Computed]
    public function ordersNonaktif()
    {
        return Order::with(['user', 'orderItems'])
            ->where('tenant_id', $this->tenant->id)
            ->whereDate('order_date', $this->tanggal)
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->orderBy('order_date', 'desc')
            ->get();
    }

    public function updateStatus(int $orderId, string $status): void
    {
        $order = Order::where('tenant_id', $this->tenant->id)->findOrFail($orderId);

        $valid = ['pending', 'diproses', 'selesai', 'dibatalkan'];
        if (! in_array($status, $valid)) {
            return;
        }

        $order->update(['status' => $status]);
    }

    public function render()
    {
        return view('livewire.tenant-orders', [
            'tenant' => $this->tenant,
            'ordersAktif' => $this->ordersAktif,
            'ordersNonaktif' => $this->ordersNonaktif,
        ]);
    }
}
