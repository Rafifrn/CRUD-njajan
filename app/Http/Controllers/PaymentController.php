<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Struk digital HTML (print-friendly) per grup pembayaran.
     */
    public function struk(string $groupCode)
    {
        $payment = Payment::where('group_code', $groupCode)
            ->with(['orders.orderItems', 'orders.tenant', 'orders.user'])
            ->firstOrFail();

        // Hanya pemilik order atau admin yang boleh lihat struk
        $user = request()->user();
        $isOwner = $payment->orders->contains(fn ($o) => $o->user_id === $user->id);
        if (! $isOwner && $user->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        return view('user.struk', compact('payment'));
    }
}
