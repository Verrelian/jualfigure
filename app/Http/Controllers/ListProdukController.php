<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Specification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ListProdukController extends Controller
{
    public function show()
    {
        $produk = Produk::orderBy('harga', 'desc')->get();
        return view('pages.seller.product', compact('produk'));
    }
    public function getSpecification($id)
    {
        try {
            $produk = Produk::with('specification')->findOrFail($id);

            $spec = $produk->specification;

            if (!$spec) {  // jika tidak ada spesifikasi
                return response()->json([]);
            }

            $data = [];

            if ($spec->scale) $data['Scale'] = $spec->scale;
            if ($spec->material) $data['Material'] = $spec->material;
            if ($spec->manufacture) $data['Manufacture'] = $spec->manufacture;
            if ($spec->release_date) $data['Release Date'] = $spec->release_date;
            if ($spec->series) $data['Series'] = $spec->series;

            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json([]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'type' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Validasi spesifikasi sebagai array assosiatif
            'specification' => 'nullable|array',
            'specification.scale' => 'nullable|string|max:255',
            'specification.material' => 'nullable|string|max:255',
            'specification.manufacture' => 'nullable|string|max:255',
            'specification.release_date' => 'nullable|date',
            'specification.series' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . $validator->errors()->first()
            ], 422);
        }

        try {
            $data = $request->only(['nama', 'deskripsi', 'type', 'harga', 'stok']);

            if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
                $image = $request->file('gambar');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $data['gambar'] = $imageName; // simpan nama file saja
            }


            // Simpan produk
            $produk = Produk::create($data);

            // Simpan specification terkait jika ada
            if ($request->has('specification')) {
                $spec = $request->input('specification');
                $produk->specification()->create([
                    'scale' => $spec['scale'] ?? null,
                    'material' => $spec['material'] ?? null,
                    'manufacture' => $spec['manufacture'] ?? null,
                    'release_date' => $spec['release_date'] ?? null,
                    'series' => $spec['series'] ?? null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan!',
                'data' => $produk
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'type' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Validasi spesifikasi sebagai array assosiatif
            'specification' => 'nullable|array',
            'specification.scale' => 'nullable|string|max:255',
            'specification.material' => 'nullable|string|max:255',
            'specification.manufacture' => 'nullable|string|max:255',
            'specification.release_date' => 'nullable|date',
            'specification.series' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . $validator->errors()->first()
            ], 422);
        }

        try {
            $produk = Produk::findOrFail($id);
            $data = $request->only(['nama', 'deskripsi', 'type', 'harga', 'stok']);

            if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
                if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                    Storage::disk('public')->delete($produk->gambar);
                }
                $image = $request->file('gambar');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                $data['gambar'] = $imagePath;
            }

            $produk->update($data);

            // Hapus dulu spesifikasi lama
            $produk->specification()->delete();

            // Simpan ulang spesifikasi baru jika ada
            if ($request->has('specification')) {
                $spec = $request->input('specification');
                $produk->specification()->create([
                    'scale' => $spec['scale'] ?? null,
                    'material' => $spec['material'] ?? null,
                    'manufacture' => $spec['manufacture'] ?? null,
                    'release_date' => $spec['release_date'] ?? null,
                    'series' => $spec['series'] ?? null,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diupdate!',
                'data' => $produk
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $produk = Produk::findOrFail($id);

            // Hapus specification terkait
            $produk->specification()->delete();

            // Hapus produk
            $produk->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus dari database!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}