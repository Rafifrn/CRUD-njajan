<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\UpdateOrderRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * PESANAN: order milik user yang login (status aktif hari ini).
     */
    public function myOrders()
    {
        $orders = Order::with(['tenant', 'orderItems', 'payment'])
            ->where('user_id', Auth::id())
            ->whereDate('order_date', today())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.pesanan', compact('orders'));
    }

    /**
     * HISTORY: semua histori order user.
     */
    public function history()
    {
        $orders = Order::with(['tenant', 'orderItems', 'payment'])
            ->where('user_id', Auth::id())
            ->orderBy('order_date', 'desc')
            ->paginate(15);

        return view('user.history', compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('user', 'tenant', 'orderItems');
        return view('admin.showOrder', compact('order'));
    }

    /**
     * Update status order (dipakai admin/tenant).
     */
    public function updateStatus(UpdateOrderRequest $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,dibatalkan'
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()
            ->with('success', 'Status pesanan diperbarui.');
    }
}
