<!-- Modal Bukti Pembayaran -->
<div id="buktiModal" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 hidden">
    <div class="bg-gray-800 text-white rounded-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold">Upload Bukti Pembayaran</h2>
            <button onclick="closeBuktiModal()" class="text-gray-400 hover:text-white">
                &times;
            </button>
        </div>

        <p class="mb-2 text-sm text-gray-300">
            Silakan transfer ke nomor rekening berikut dan upload bukti pembayaran:
        </p>

        <div class="mb-4">
            <p><strong>Bank:</strong> BCA</p>
            <p><strong>No. Rekening:</strong> 1234567890</p>
            <p><strong>Atas Nama:</strong> PT MOLE Store</p>
        </div>

        <form action="upload_bukti.php" method="POST" enctype="multipart/form-data">
            <label for="buktiPembayaran" class="block text-sm mb-1">Upload Bukti:</label>
            <input type="file" name="buktiPembayaran" id="buktiPembayaran" required
                   class="block w-full text-sm text-gray-300 bg-gray-700 rounded p-2 mb-4">

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded font-semibold">
                Kirim Bukti Pembayaran
            </button>
        </form>
    </div>
</div>