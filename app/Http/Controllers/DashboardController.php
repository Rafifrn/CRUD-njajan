<?php

namespace App\Http\Controllers;

use App\Models\Makanan;
use App\Models\Menu;
use App\Models\Minuman;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalOrder = Order::count();
        $completedOrder = Order::where('status', 'completed')->count();
        $totalUser = User::count();
        
        // Ini bagian penting: keuntungan dihitung dari order yang sudah selesai
        $keuntungan = Order::where('status', 'completed')->sum('total');

        $totalMenus = Makanan::count();

        $pendingOrders = Order::where('status', 'pending')->count();
        
        return view('home', compact(
            'totalOrder',
            'completedOrder',
            'totalUser',
            'keuntungan',
            'totalMenus',
            'pendingOrders',
        ));
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
        //
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
