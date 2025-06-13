<?php

namespace App\Http\Controllers\admin;

use App\Models\Makanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;

class MakananController extends Controller
{
    /**p
     * Display a listing of the resource.
     */
    public function index()
    {
         $makanans = Makanan::all();
    return view('admin.makananIndex', compact('makanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.createMakanan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'region' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $slug = Str::slug($request->name); // otomatis generate slug

    // Cek jika slug sudah ada di database
    $count = \App\Models\Makanan::where('slug', $slug)->count();
    if ($count > 0) {
        $slug .= '-' . ($count + 1); // hindari duplikat slug
    }

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('makanan', 'public');
    }

    Makanan::create([
        'name' => $request->name,
        'slug' => $slug,
        'description' => $request->description,
        'price' => $request->price,
        'region' => $request->region,
        'image' => $imagePath,
    ]);

    return redirect()->route('admin.makanan.create')->with('success', 'Makanan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Makanan $makanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $makanan = Makanan::findOrFail($id);
    return view('admin.editMakanan', compact('makanan'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $makanan = Makanan::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'region' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $slug = Str::slug($request->name);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('makanan', 'public');
        $makanan->image = $imagePath;
    }

    $makanan->update([
        'name' => $request->name,
        'slug' => $slug,
        'description' => $request->description,
        'price' => $request->price,
        'region' => $request->region,
    ]);

    return redirect()->route('admin.makanan.index')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $makanan = Makanan::findOrFail($id);
    $makanan->delete();
    return redirect()->route('admin.makanan.index')->with('success', 'Data berhasil dihapus.');
    }
}
