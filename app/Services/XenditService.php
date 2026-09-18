<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Str;
use Xendit\Xendit;

class XenditService
{
    public function __construct()
    {
        $key = config('services.xendit.secret_key');
        if (empty($key)) {
            throw new \RuntimeException('XENDIT_SECRET_KEY belum di-set di .env');
        }
        Xendit::setApiKey($key);
    }

    /**
     * Buat invoice Xendit untuk 1 grup checkout (bisa banyak order multi-tenant).
     */
    public function createInvoice(Payment $payment): array
    {
        $orders = $payment->orders()->with('orderItems')->get();

        $items = [];
        foreach ($orders as $order) {
            foreach ($order->orderItems as $item) {
                $items[] = [
                    'name' => $item->name . ($order->tenant ? ' (' . $order->tenant->name . ')' : ''),
                    'quantity' => (int) $item->qty,
                    'price' => (float) $item->price,
                    'category' => $item->product_type,
                ];
            }
        }

        $params = [
            'external_id' => $payment->group_code,
            'amount' => (int) $payment->amount,
            'description' => 'Pembayaran pesanan ' . $payment->group_code,
            'invoice_duration' => 86400,
            'customer' => [
                'given_names' => optional($payment->orders->first()->user)->name ?? 'Pelanggan',
                'email' => optional($payment->orders->first()->user)->email ?? 'guest@example.com',
            ],
            'success_redirect_url' => route('payment.success', $payment->group_code),
            'failure_redirect_url' => route('payment.failed', $payment->group_code),
            'currency' => 'IDR',
            'items' => $items,
        ];

        $response = \Xendit\Invoice::create($params);

        $payment->update([
            'xendit_invoice_id' => $response['id'] ?? null,
            'invoice_url' => $response['invoice_url'] ?? null,
            'status' => $response['status'] ?? 'pending',
        ]);

        return $response;
    }

    /**
     * Proses callback dari Xendit webhook.
     */
    public function handleCallback(array $payload): void
    {
        $groupCode = $payload['external_id'] ?? null;
        if (! $groupCode) {
            return;
        }

        $payment = Payment::where('group_code', $groupCode)->first();
        if (! $payment) {
            return;
        }

        $status = $payload['status'] ?? null;
        $payment->update([
            'status' => $status === 'PAID' || $status === 'SETTLED' ? 'paid' : strtolower((string) $status),
            'method' => $payload['payment_method'] ?? null,
            'payment_channel' => $payload['payment_channel'] ?? null,
            'paid_at' => ($status === 'PAID' || $status === 'SETTLED') ? now() : $payment->paid_at,
        ]);

        if ($status === 'PAID' || $status === 'SETTLED') {
            Order::where('payment_group', $groupCode)->update([
                'payment_status' => 'paid',
                'status' => 'pending', // masuk antrian tenant setelah dibayar
            ]);
        } elseif ($status === 'EXPIRED') {
            Order::where('payment_group', $groupCode)->update([
                'status' => 'dibatalkan',
            ]);
        }
    }
}
