<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atk;
use Illuminate\Support\Facades\Storage;

class AtkController extends Controller
{
    public function index()
    {
        return response()->json(Atk::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|in:alat_tulis,kertas,peralatan,lainnya',
            'satuan' => 'required|in:pcs,box,pak,rim',
            'stok' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/atk', $filename, 'public');
            $validated['gambar'] = $path;
        }

        $atk = Atk::create($validated);
        return response()->json($atk, 201);
    }

    public function show($id)
    {
        $atk = Atk::findOrFail($id);
        return response()->json($atk);
    }

    public function update(Request $request, $id)
    {
        try {
            $atk = Atk::findOrFail($id);
            
            $validated = $request->validate([
                'kode_barang' => 'required|string|max:50',
                'nama_barang' => 'required|string|max:255',
                'kategori' => 'required|in:alat_tulis,kertas,peralatan,lainnya',
                'satuan' => 'required|in:pcs,box,pak,rim',
                'stok' => 'required|integer|min:0',
                'keterangan' => 'nullable|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->hasFile('gambar')) {
                if ($atk->gambar && Storage::disk('public')->exists($atk->gambar)) {
                    Storage::disk('public')->delete($atk->gambar);
                }
                $file = $request->file('gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads/atk', $filename, 'public');
                $validated['gambar'] = $path;
            }

            $atk->update($validated);
            return response()->json([
                'message' => 'Data berhasil diupdate',
                'data' => $atk
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
            $atk = Atk::findOrFail($id);
            if ($atk->gambar && Storage::disk('public')->exists($atk->gambar)) {
                Storage::disk('public')->delete($atk->gambar);
            }
            $atk->delete();
            return response()->json(['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data'], 500);
        }
    }
}