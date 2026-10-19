<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Models\Minuman;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Checkout: pecah cart jadi order per tenant, lalu buat 1 payment grup.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_type' => 'required|in:makanan,minuman',
            'items.*.id' => 'required|integer',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $user = $request->user();

        // Validasi harga & stok server-side
        $items = collect($validated['items']);
        $makananIds = $items->where('product_type', 'makanan')->pluck('id');
        $minumanIds = $items->where('product_type', 'minuman')->pluck('id');

        $makanans = Makanan::whereIn('id', $makananIds)->get()->keyBy('id');
        $minumans = Minuman::whereIn('id', $minumanIds)->get()->keyBy('id');

        // Susun item + ambil tenant_id dari produk
        $prepared = [];
        foreach ($items as $item) {
            $product = $item['product_type'] === 'makanan'
                ? ($makanans[$item['id']] ?? null)
                : ($minumans[$item['id']] ?? null);

            if (! $product || ! $product->is_available) {
                return response()->json([
                    'success' => false,
                    'message' => "Produk {$item['id']} tidak tersedia.",
                ], 422);
            }
            if (! $product->tenant_id) {
                return response()->json([
                    'success' => false,
                    'message' => "Produk {$product->name} belum terhubung ke tenant.",
                ], 422);
            }

            $prepared[] = [
                'product_type' => $item['product_type'],
                'product' => $product,
                'qty' => $item['qty'],
                'subtotal' => $product->price * $item['qty'],
            ];
        }

        $groupCode = 'PAY-' . strtoupper(Str::random(10));

        try {
            DB::beginTransaction();

            // Pecah per tenant
            $byTenant = collect($prepared)->groupBy(fn ($i) => $i['product']->tenant_id);

            $orders = [];
            foreach ($byTenant as $tenantId => $tenantItems) {
                $total = $tenantItems->sum('subtotal');

                $order = Order::create([
                    'user_id' => $user->id,
                    'tenant_id' => $tenantId,
                    'kode' => 'ORD-' . strtoupper(Str::random(8)),
                    'payment_group' => $groupCode,
                    'items' => $tenantItems->map(fn ($i) => [
                        'id' => $i['product']->id,
                        'product_type' => $i['product_type'],
                        'name' => $i['product']->name,
                        'price' => (float) $i['product']->price,
                        'qty' => $i['qty'],
                        'subtotal' => $i['subtotal'],
                    ])->all(),
                    'total' => $total,
                    'status' => 'pending',
                    'payment_status' => 'unpaid',
                    'order_date' => now(),
                ]);

                foreach ($tenantItems as $i) {
                    $order->orderItems()->create([
                        'product_type' => $i['product_type'],
                        'product_id' => $i['product']->id,
                        'name' => $i['product']->name,
                        'price' => $i['product']->price,
                        'qty' => $i['qty'],
                        'subtotal' => $i['subtotal'],
                    ]);
                }

                $orders[] = $order;
            }

            $payment = Payment::create([
                'group_code' => $groupCode,
                'amount' => collect($prepared)->sum('subtotal'),
                'status' => 'pending',
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage(),
            ], 500);
        }

        // BYPASS PAYMENT - auto mark as paid for development
        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        foreach ($orders as $order) {
            $order->update(['payment_status' => 'paid']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat dan otomatis terbayar.',
            'payment_group' => $groupCode,
            'orders' => collect($orders)->map(fn ($o) => ['id' => $o->id, 'kode' => $o->kode, 'tenant' => $o->tenant->name, 'total' => $o->total]),
            'redirect_url' => route('payment.success', ['groupCode' => $groupCode]),
        ]);
    }

    /**
     * Halaman sukses setelah bayar (redirect dari Xendit).
     */
    public function success(string $groupCode)
    {
        $payment = Payment::where('group_code', $groupCode)
            ->with('orders.orderItems', 'orders.tenant')
            ->firstOrFail();
        $this->authorizePayment($payment);

        return view('payment.success', compact('payment'));
    }

    /**
     * Halaman gagal/batal bayar.
     */
    public function failed(string $groupCode)
    {
        $payment = Payment::where('group_code', $groupCode)
            ->with('orders')
            ->firstOrFail();
        $this->authorizePayment($payment);

        return view('payment.failed', compact('payment'));
    }

    private function authorizePayment(Payment $payment): void
    {
        $user = request()->user();
        abort_unless(
            $user->role === 'admin' || $payment->orders->contains('user_id', $user->id),
            403,
            'Akses ditolak.'
        );
    }
}
