<?php

namespace App\Http\Controllers\admin;

use App\Models\Minuman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;

class MinumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $minumans = Minuman::all();
    return view('admin.minumanIndex', compact('minumans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.createMinuman');
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
    $count = \App\Models\Minuman::where('slug', $slug)->count();
    if ($count > 0) {
        $slug .= '-' . ($count + 1); // hindari duplikat slug
    }

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('minuman', 'public');
    }

    Minuman::create([
        'name' => $request->name,
        'slug' => $slug,
        'description' => $request->description,
        'price' => $request->price,
        'region' => $request->region,
        'image' => $imagePath,
    ]);

    return redirect()->route('admin.minuman.create')->with('success', 'Minuman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Minuman $minuman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $minuman = Minuman::findOrFail($id);
    return view('admin.editMinuman', compact('minuman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $minuman = Minuman::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'region' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $slug = Str::slug($request->name);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('minuman', 'public');
        $minuman->image = $imagePath;
    }

    $minuman->update([
        'name' => $request->name,
        'slug' => $slug,
        'description' => $request->description,
        'price' => $request->price,
        'region' => $request->region,
    ]);

    return redirect()->route('admin.minuman.index')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $minuman = Minuman::findOrFail($id);
    $minuman->delete();
    return redirect()->route('admin.minuman.index')->with('success', 'Data berhasil dihapus.');
    }
}
