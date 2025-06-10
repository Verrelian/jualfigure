<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Specification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ListProdukController extends Controller
{
    public function show()
    {
        // Load dengan spesifikasi untuk data edit
        $produk = Produk::with('specification')->orderBy('price', 'desc')->get();
        return view('pages.seller.crud', compact('produk'));
    }

    public function getSpecification($product_id)
    {
        try {
            $produk = Produk::with('specification')->findOrFail($product_id);
            $spec = $produk->specification;

            if (!$spec) return response()->json([]);

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

    private function validateProductData($request, $isUpdate = false)
    {
        $rules = [
            'product_name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'type' => 'required|string|max:100',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:0',
            // Spesifikasi OPTIONAL - tidak wajib diisi
            'specification.scale' => 'nullable|string|max:50',
            'specification.material' => 'nullable|string|max:100',
            'specification.manufacture' => 'nullable|string|max:100',
            'specification.release_date' => 'nullable|date',
            'specification.series' => 'nullable|string|max:100',
        ];

        // Untuk create, image wajib. Untuk update, image optional
        if ($isUpdate) {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        } else {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        }

        $messages = [
            'product_name.required' => 'product_name produk wajib diisi',
            'product_name.max' => 'product_name produk maksimal 255 karakter',
            'description.required' => 'description produk wajib diisi',
            'description.max' => 'description maksimal 1000 karakter',
            'type.required' => 'Type produk wajib diisi',
            'type.max' => 'Type maksimal 100 karakter',
            'price.required' => 'price wajib diisi',
            'price.numeric' => 'price harus berupa angka',
            'price.min' => 'price minimal Rp 1',
            'stock.required' => 'stock wajib diisi',
            'stock.integer' => 'stock harus berupa angka bulat',
            'stock.min' => 'stock tidak boleh negatif',
            'image.required' => 'image produk wajib diupload',
            'image.image' => 'File harus berupa image',
            'image.mimes' => 'Format image yang diperbolehkan: JPEG, PNG, JPG, GIF, WEBP',
            'image.max' => 'Ukuran image maksimal 2MB',
            'specification.scale.max' => 'Scale maksimal 50 karakter',
            'specification.material.max' => 'Material maksimal 100 karakter',
            'specification.manufacture.max' => 'Manufacture maksimal 100 karakter',
            'specification.release_date.date' => 'Format tanggal release tidak valid',
            'specification.series.max' => 'Series maksimal 100 karakter',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    private function handleImageUpload($request, $oldImage = null)
    {
        if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
            return null;
        }

        // Hapus image lama jika ada
        if ($oldImage && file_exists(public_path('images/' . $oldImage))) {
            unlink(public_path('images/' . $oldImage));
        }

        $image = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

        // Pindahkan ke folder public/images
        $image->move(public_path('images'), $imageName);

        return $imageName;
    }

    private function saveSpecification($produk, $specData, $isUpdate = false)
    {
        if (!$specData) {
            return;
        }

        // Untuk create, buat record baru
        if (!$isUpdate) {
            // Cek apakah ada minimal satu field yang diisi
            $hasSpecData = false;
            foreach ($specData as $value) {
                if (!empty($value)) {
                    $hasSpecData = true;
                    break;
                }
            }

            // Simpan hanya jika ada data yang diisi
            if ($hasSpecData) {
                $produk->specification()->create([
                    'scale' => !empty($specData['scale']) ? $specData['scale'] : null,
                    'material' => !empty($specData['material']) ? $specData['material'] : null,
                    'manufacture' => !empty($specData['manufacture']) ? $specData['manufacture'] : null,
                    'release_date' => !empty($specData['release_date']) ? $specData['release_date'] : null,
                    'series' => !empty($specData['series']) ? $specData['series'] : null,
                ]);
            }
        } else {
            // Untuk update, update field yang ada atau buat baru jika belum ada
            $specification = $produk->specification;

            if ($specification) {
                // Update existing specification
                $updateData = [];

                // Hanya update field yang dikirim dalam request
                if (array_key_exists('scale', $specData)) {
                    $updateData['scale'] = !empty($specData['scale']) ? $specData['scale'] : null;
                }
                if (array_key_exists('material', $specData)) {
                    $updateData['material'] = !empty($specData['material']) ? $specData['material'] : null;
                }
                if (array_key_exists('manufacture', $specData)) {
                    $updateData['manufacture'] = !empty($specData['manufacture']) ? $specData['manufacture'] : null;
                }
                if (array_key_exists('release_date', $specData)) {
                    $updateData['release_date'] = !empty($specData['release_date']) ? $specData['release_date'] : null;
                }
                if (array_key_exists('series', $specData)) {
                    $updateData['series'] = !empty($specData['series']) ? $specData['series'] : null;
                }

                // Update hanya jika ada data yang akan diupdate
                if (!empty($updateData)) {
                    $specification->update($updateData);
                }
            } else {
                // Buat specification baru jika belum ada
                $hasSpecData = false;
                foreach ($specData as $value) {
                    if (!empty($value)) {
                        $hasSpecData = true;
                        break;
                    }
                }

                if ($hasSpecData) {
                    $produk->specification()->create([
                        'scale' => !empty($specData['scale']) ? $specData['scale'] : null,
                        'material' => !empty($specData['material']) ? $specData['material'] : null,
                        'manufacture' => !empty($specData['manufacture']) ? $specData['manufacture'] : null,
                        'release_date' => !empty($specData['release_date']) ? $specData['release_date'] : null,
                        'series' => !empty($specData['series']) ? $specData['series'] : null,
                    ]);
                }
            }
        }
    }

    public function store(Request $request)
    {
        $validator = $this->validateProductData($request, false);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->only(['product_name', 'description', 'type', 'price', 'stock']);

            // Handle image upload
            $imageName = $this->handleImageUpload($request);
            if ($imageName) {
                $data['image'] = $imageName;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupload image. Pastikan file image valid.'
                ], 422);
            }

            $produk = Produk::create($data);

            // Save specification jika ada
            if ($request->has('specification')) {
                $this->saveSpecification($produk, $request->input('specification'), false);
            }

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan!',
                'data' => $produk->load('specification')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $product_id)
    {
        $validator = $this->validateProductData($request, true);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $produk = Produk::findOrFail($product_id);
            $data = $request->only(['product_name', 'description', 'type', 'price', 'stock']);

            // Handle image upload jika ada file baru
            if ($request->hasFile('image')) {
                $imageName = $this->handleImageUpload($request, $produk->image);
                if ($imageName) {
                    $data['image'] = $imageName;
                }
            }

            $produk->update($data);

            // Update specification - gunakan flag isUpdate = true
            if ($request->has('specification')) {
                $this->saveSpecification($produk, $request->input('specification'), true);
            }

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diupdate!',
                'data' => $produk->load('specification')
            ]);

        } catch (\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan!'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($product_id)
    {
        try {
            $produk = Produk::findOrFail($product_id);

            // Hapus image jika ada
            if ($produk->image && file_exists(public_path('images/' . $produk->image))) {
                unlink(public_path('images/' . $produk->image));
            }

            // Hapus spesifikasi dan produk
            $produk->specification()->delete();
            $produk->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus!'
            ]);

        } catch (\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan!'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }
}