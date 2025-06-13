<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'telepon' => 'nullable|string|max:20',
        'alamat' => 'required|string',
        'items' => 'required|array',
    ]);

    // Hitung total harga dari item
    $totalHarga = collect($request->items)->sum(function ($item) {
        return $item['jumlah'] * $item['harga'];
    });

    // Simpan order ke database
    Order::create([
        'nama' => $request->nama,
        'telepon' => $request->telepon,
        'alamat' => $request->alamat,
        'total_harga' => $totalHarga,
        'items' => json_encode($request->items),
    ]);

    // Kosongkan session cart (jika kamu menggunakan session)
    session()->forget('cart');

    return redirect('/admin/home')->with('success', 'Pesanan berhasil disimpan!');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
