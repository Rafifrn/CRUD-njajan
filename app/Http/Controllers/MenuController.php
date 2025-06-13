<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Makanan;
use App\Models\Minuman;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Minus;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $makanans = Makanan::all();
        $minumans = Minuman::all();

        return view('menu', compact('makanans', 'minumans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($kategori = null, $id = null)
    {
        if (!$kategori || !$id) {
        abort(404);
    }

    $model = match ($kategori) {
        'makanan' => Makanan::class,
        'minuman' => Minuman::class,
        default => abort(404),
    };

    $item = $model::findOrFail($id);

    // Lempar data ke view pesan (view belum kita bahas)
    return view('pesan', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        //
    }

    public function daftarMenu(Request $request)
{
    $daerah = $request->query('daerah'); // ambil filter dari query string

    $makanans = Makanan::query();
    $minumans = Minuman::query();

    if ($daerah) {
        $makanans->where('daerah', $daerah);
        $minumans->where('daerah', $daerah);
    }

    return view('menu.daftar', [
        'makanans' => $makanans->get(),
        'minumans' => $minumans->get(),
        'daerahDipilih' => $daerah,
    ]);
}
public function getItemData($kategori, $id)
    {
        switch ($kategori) {
            case 'makanan':
                $item = Makanan::find($id);
                break;
            case 'minuman':
                $item = Minuman::find($id);
                break;
            default:
                return response()->json(['error' => 'Kategori tidak valid'], 400);
        }

        if (!$item) {
            return response()->json(['error' => 'Item tidak ditemukan'], 404);
        }

        return response()->json([
            'name' => $item->name,
            'description' => $item->description,
            'price' => $item->price,
            'image' => $item->image,
            'region' => $item->region,
        ]);
    }

}
