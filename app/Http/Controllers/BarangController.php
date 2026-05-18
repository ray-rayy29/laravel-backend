<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        return response()->json(Barang::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'merk' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/barang', $filename, 'public');
            $validated['gambar'] = $path;
        }

        $barang = Barang::create($validated);
        return response()->json($barang, 201);
    }

    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        try {
            $barang = Barang::findOrFail($id);

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'merk' => 'required|string|max:100',
                'stok' => 'required|integer|min:0',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->hasFile('gambar')) {
                if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                    Storage::disk('public')->delete($barang->gambar);
                }

                $file = $request->file('gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads/barang', $filename, 'public');
                $validated['gambar'] = $path;
            }

            $barang->update($validated);
            return response()->json([
                'message' => 'Data berhasil diupdate',
                'data' => $barang
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal update data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $barang = Barang::findOrFail($id);

            if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                Storage::disk('public')->delete($barang->gambar);
            }

            $barang->delete();
            return response()->json(['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data'], 500);
        }
    }
}
