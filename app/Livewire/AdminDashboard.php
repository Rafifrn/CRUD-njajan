<?php

namespace App\Livewire;

use App\Models\Makanan;
use App\Models\Minuman;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Tenant;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AdminDashboard extends Component
{
    #[Computed]
    public function stats(): array
    {
        return [
            'totalOrder' => Order::count(),
            'orderHariIni' => Order::whereDate('order_date', today())->count(),
            'orderPending' => Order::where('status', 'pending')->count(),
            'orderDiproses' => Order::where('status', 'diproses')->count(),
            'orderSelesai' => Order::where('status', 'selesai')->count(),
            'totalTenant' => Tenant::count(),
            'totalUser' => User::where('role', 'user')->count(),
            'totalProduk' => Makanan::count() + Minuman::count(),
            'keuntungan' => (float) Order::where('status', 'selesai')->sum('total'),
            'omzetHariIni' => (float) Order::whereDate('order_date', today())->where('payment_status', 'paid')->sum('total'),
        ];
    }

    #[Computed]
    public function topTenants()
    {
        return Tenant::withSum(['orders' => fn ($q) => $q->where('status', 'selesai')], 'total')
            ->orderByDesc('orders_sum_total')
            ->take(5)
            ->get();
    }

    #[Computed]
    public function orderTerbaru()
    {
        return Order::with(['user', 'tenant'])
            ->latest('order_date')
            ->take(8)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin-dashboard', [
            'stats' => $this->stats(),
            'topTenants' => $this->topTenants(),
            'orderTerbaru' => $this->orderTerbaru(),
        ]);
    }
}
