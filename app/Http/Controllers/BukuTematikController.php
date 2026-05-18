<?php

namespace App\Http\Controllers;

use App\Models\BukuTematik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuTematikController extends Controller
{
    public function index()
    {
        return response()->json(BukuTematik::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_rak' => 'required|string|max:20',
            'judul' => 'required|string|max:255',
            'penerbit' => 'required|string|max:100',
            'kelas' => 'required|string|max:10',
            'semester' => 'required|in:1,2',
            'kurikulum' => 'required|in:kurikulum_merdeka,kurikulum_2013',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/buku_tematik', $filename, 'public');
            $validated['gambar'] = $path;
        }

        $bukuTematik = BukuTematik::create($validated);
        return response()->json($bukuTematik, 201);
    }

    public function show($id)
    {
        $bukuTematik = BukuTematik::findOrFail($id);
        return response()->json($bukuTematik);
    }

    public function update(Request $request, $id)
    {
        try {
            $bukuTematik = BukuTematik::findOrFail($id);

            $validated = $request->validate([
                'nomor_rak' => 'required|string|max:20',
                'judul' => 'required|string|max:255',
                'penerbit' => 'required|string|max:100',
                'kelas' => 'required|string|max:10',
                'semester' => 'required|in:1,2',
                'kurikulum' => 'required|in:kurikulum_merdeka,kurikulum_2013',
                'stok' => 'required|integer|min:0',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->hasFile('gambar')) {
                if ($bukuTematik->gambar && Storage::disk('public')->exists($bukuTematik->gambar)) {
                    Storage::disk('public')->delete($bukuTematik->gambar);
                }

                $file = $request->file('gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads/buku_tematik', $filename, 'public');
                $validated['gambar'] = $path;
            }

            $bukuTematik->update($validated);
            return response()->json([
                'message' => 'Data berhasil diupdate',
                'data' => $bukuTematik
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
            $bukuTematik = BukuTematik::findOrFail($id);

            if ($bukuTematik->gambar && Storage::disk('public')->exists($bukuTematik->gambar)) {
                Storage::disk('public')->delete($bukuTematik->gambar);
            }

            $bukuTematik->delete();
            return response()->json([
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
