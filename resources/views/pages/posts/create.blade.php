<form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 px-6 py-4">
    @csrf

    {{-- Title --}}
    <div>
        <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul Postingan</label>
        <input type="text" name="title" id="title"
               class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm"
               placeholder="Contoh: Pajangan baru keren banget!" required>
    </div>

    {{-- Description --}}
    <div>
        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
        <textarea name="description" id="description" rows="4"
                  class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm resize-none"
                  placeholder="Ceritakan koleksimu atau pengalamanmu..." required></textarea>
    </div>

    {{-- Upload --}}
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Upload Gambar</label>
        <input type="file" name="images[]" multiple accept="image/*"
               class="block w-full text-sm text-gray-500
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-full file:border-0
                      file:text-sm file:font-semibold
                      file:bg-blue-50 file:text-blue-700
                      hover:file:bg-blue-100" />
        <p class="mt-2 text-sm text-gray-400">Bisa pilih beberapa gambar sekaligus (max 2MB per gambar).</p>
    </div>

    {{-- Submit --}}
    <div class="flex justify-end">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full font-medium transition">
            Posting Sekarang
        </button>
    </div>
</form>
