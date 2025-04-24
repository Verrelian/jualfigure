<div x-data="{ quantity: 1 }" class="grid md:grid-cols-2 gap-6 items-start bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
    <div>
        <img src="{{ asset('images/ProductDetail.jpg') }}" alt="Himura Kenshin Figure" class="rounded-lg">
        <p class="text-red-600 font-bold text-xl mt-2">IDR 690,000</p>
    </div>
    
    <div>
        <h1 class="text-2xl font-bold mb-4">[Hanami SALE] PVC Non Scale Figure Himura Kenshin – Rurouni Kenshin</h1>
        
        <label class="block text-sm mb-2 font-medium">Quantity</label>
        <div class="flex items-center gap-2 mb-4">
    <button @click="quantity > 1 ? quantity-- : 1" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
    <span class="text-lg font-medium w-8 text-center" x-text="quantity"></span>
    <button @click="quantity++" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>

    <!-- Favorite Icon -->
    <button class="ml-4 text-gray-500 hover:text-red-500 text-xl">
        <i class="fas fa-heart"></i>
    </button>
</div>

        
        <div class="text-sm space-y-2 bg-gray-100 dark:bg-gray-700 p-4 rounded">
            <p>From <strong>‘Rurouni Kenshin’</strong>, the main character Kenshin Himura has been sculpted as a non-scale figure!</p>
            <p>Kenshin is posed sitting on a chair with a gentle yet strong expression on his face.</p>
            <p>Costumes are created by modeling the thickness and flexure of his clothing with a focus on texture.</p>
            <p>Under special supervision, every detail has been carefully considered.</p>
            <p>Bring Kenshin Himura home at an affordable price and with a lot of attention to detail!</p>
            <p>Painted plastic non-scale complete product. Approximately 155mm in height.</p>
        </div>

        <div x-data="{ showModal: false }">
        <div x-data="{ showModal: false, metode: '', alamat: '' }">
    <!-- Tombol Buy It Now -->
    <button @click="showModal = true" class="w-full mt-6 py-3 rounded-lg bg-black text-white font-semibold hover:bg-gray-800">
        Buy It Now
    </button>

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
        <div class="bg-white p-6 rounded-2xl w-full max-w-md space-y-4 relative">
            <h2 class="text-lg font-bold text-center">Pilih Metode Pembayaran</h2>

            <!-- Metode Pembayaran -->
            <div class="flex justify-around items-center">
                <div @click="metode = 'BCA'" :class="metode === 'BCA' ? 'ring-2 ring-blue-500' : ''"
                     class="text-center cursor-pointer p-2 rounded transition-all">
                    <img src="{{ asset('images/BCA.jpg') }}" alt="BCA" class="h-12 mx-auto">
                    <p class="text-sm mt-1">Bank BCA</p>
                </div>
                <div @click="metode = 'BRI'" :class="metode === 'BRI' ? 'ring-2 ring-blue-500' : ''"
                     class="text-center cursor-pointer p-2 rounded transition-all">
                    <img src="{{ asset('images/BRI.jpg') }}" alt="BRI" class="h-12 mx-auto">
                    <p class="text-sm mt-1">Bank BRI</p>
                </div>
                <div @click="metode = 'BNI'" :class="metode === 'BNI' ? 'ring-2 ring-blue-500' : ''"
                     class="text-center cursor-pointer p-2 rounded transition-all">
                    <img src="{{ asset('images/BNI.jpg') }}" alt="BNI" class="h-12 mx-auto">
                    <p class="text-sm mt-1">Bank BNI</p>
                </div>
            </div>

            <!-- Alamat Pengiriman -->
            <input type="text" x-model="alamat" placeholder="Masukkan alamat pengiriman" class="w-full p-2 border rounded">

            <!-- Tombol Aksi -->
            <div class="flex justify-end gap-2 pt-2">
                <button @click="showModal = false" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button
                    :disabled="!metode || !alamat"
                    :class="{ 'opacity-50 cursor-not-allowed': !metode || !alamat }"
                    @click="window.location.href = `/order-detail?metode=${metode}&alamat=${alamat}`"
                    class="px-4 py-2 bg-black text-white rounded">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>


