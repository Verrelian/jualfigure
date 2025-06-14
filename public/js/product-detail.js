document.addEventListener('DOMContentLoaded', function () {
    function getCurrentDateTime() {
        const now = new Date();
        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const year = now.getFullYear();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
    }

    const buyNowBtn = document.getElementById('buyNowBtn');
    const paymentModal = document.getElementById('paymentModal');
    const closeModal = document.getElementById('closeModal');
    const confirmPayment = document.getElementById('confirmPayment');
    const paymentMethod = document.getElementById('paymentMethod');
    const receiptModal = document.getElementById('receiptModal');
    const closeReceiptModal = document.getElementById('closeReceiptModal');
    const closeReceiptBtn = document.getElementById('closeReceiptBtn');
    const downloadReceipt = document.getElementById('downloadReceipt');
    const buktiModal = document.getElementById('buktiModal');

    const orderNumber = document.getElementById('orderNumber')?.textContent || 'ORD-' + Math.floor(100000 + Math.random() * 900000);

    function closeBuktiModal() {
        buktiModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function () {
            const orderDateElement = document.getElementById('orderDate');
            if (orderDateElement) {
                orderDateElement.textContent = getCurrentDateTime();
            }
            paymentModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    }

    if (closeModal) {
        closeModal.addEventListener('click', function () {
            paymentModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
    }

    if (paymentModal) {
        paymentModal.addEventListener('click', function (e) {
            if (e.target === paymentModal) {
                paymentModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    }

    if (confirmPayment) {
        confirmPayment.addEventListener('click', function () {
            if (paymentMethod.value === '') {
                alert('Please select a payment method');
                return;
            }

            paymentModal.classList.add('hidden');
            buktiModal.classList.remove('hidden');
        });
    }

    if (buktiModal) {
        const buktiForm = buktiModal.querySelector('form');
        if (buktiForm) {
            buktiForm.addEventListener('submit', function (e) {
                e.preventDefault();

                closeBuktiModal();

                document.getElementById('receiptOrderNumber').textContent = orderNumber;
                document.getElementById('receiptDate').textContent = document.getElementById('orderDate').textContent;
                document.getElementById('receiptPaymentMethod').textContent = paymentMethod.options[paymentMethod.selectedIndex].text;

                let bankPrefix = '';
                switch (paymentMethod.value) {
                    case 'bca': bankPrefix = '014'; break;
                    case 'bni': bankPrefix = '009'; break;
                    case 'mandiri': bankPrefix = '008'; break;
                    case 'bri': bankPrefix = '002'; break;
                    default: bankPrefix = '123';
                }
                const virtualAccount = bankPrefix + Math.floor(10000000000 + Math.random() * 90000000000);
                document.getElementById('virtualAccountNumber').textContent = virtualAccount;

                document.getElementById('receiptSubtotal').textContent = document.getElementById('subtotalPrice').textContent;
                document.getElementById('receiptShipping').textContent = document.getElementById('shippingPrice').textContent;
                document.getElementById('receiptTax').textContent = document.getElementById('taxPrice').textContent;
                document.getElementById('receiptTotal').textContent = document.getElementById('totalPrice').textContent;

                receiptModal.classList.remove('hidden');
            });
        }
    }

    if (closeReceiptModal) {
        closeReceiptModal.addEventListener('click', function () {
            receiptModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
    }

    if (closeReceiptBtn) {
        closeReceiptBtn.addEventListener('click', function () {
            receiptModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
    }

    if (receiptModal) {
        receiptModal.addEventListener('click', function (e) {
            if (e.target === receiptModal) {
                receiptModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    }

    if (downloadReceipt) {
        downloadReceipt.addEventListener('click', function () {
            alert('Receipt download functionality would be implemented here. In a real application, this would generate a PDF or print version of the receipt.');
        });
    }

    if (paymentMethod) {
        paymentMethod.addEventListener('change', function () {
            const bank = this.value;
            let accountNumber = '';
            let accountName = 'PT MOLE Store';

            switch (bank) {
                case 'bca': accountNumber = '1234567890'; break;
                case 'bni': accountNumber = '0987654321'; break;
                case 'mandiri': accountNumber = '2468135790'; break;
                case 'bri': accountNumber = '1357924680'; break;
                default: accountNumber = '1234567890';
            }

            const bankNameElement = document.querySelector('#buktiModal strong:nth-of-type(1)');
            const accountNumberElement = document.querySelector('#buktiModal strong:nth-of-type(2)');
            const accountNameElement = document.querySelector('#buktiModal strong:nth-of-type(3)');

            if (bankNameElement && bankNameElement.nextSibling) {
                bankNameElement.nextSibling.textContent = ': ' + bank.toUpperCase();
            }
            if (accountNumberElement && accountNumberElement.nextSibling) {
                accountNumberElement.nextSibling.textContent = ': ' + accountNumber;
            }
            if (accountNameElement && accountNameElement.nextSibling) {
                accountNameElement.nextSibling.textContent = ': ' + accountName;
            }
        });
    }

// JavaScript untuk menangani tombol wishlist
    const wishlistBtn = document.getElementById('wishlistBtn');
    
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.getAttribute('data-product-id');
            const button = this;
            
            // Disable button sementara untuk mencegah double click
            button.disabled = true;
            button.style.opacity = '0.7';
            
            // Kirim request AJAX ke server
            fetch('/wishlist/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Ubah tampilan tombol jika berhasil
                    const svg = button.querySelector('svg');
                    svg.style.fill = 'currentColor';
                    svg.classList.remove('text-gray-600');
                    svg.classList.add('text-red-500');
                    
                    // Ubah class button untuk menunjukkan status aktif
                    button.classList.add('wishlist-active');
                    button.setAttribute('data-wishlisted', 'true');
                    
                    // Tampilkan notifikasi sukses
                    showNotification(data.message || 'Produk berhasil ditambahkan ke wishlist!', 'success');
                    
                    // Optional: Update counter wishlist jika ada
                    updateWishlistCounter();
                    
                } else {
                    showNotification(data.message || 'Gagal menambahkan ke wishlist', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (error.message.includes('401')) {
                    showNotification('Silakan login terlebih dahulu', 'error');
                } else {
                    showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                }
            })
            .finally(() => {
                // Re-enable button
                button.disabled = false;
                button.style.opacity = '1';
            });
        });
    }
});
// Fungsi untuk menampilkan notifikasi
function showNotification(message, type) {
    // Buat elemen notifikasi
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.textContent = message;
    
    // Tambahkan ke body
    document.body.appendChild(notification);
    
    // Hilangkan setelah 3 detik
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Fungsi untuk update counter wishlist (optional)
function updateWishlistCounter() {
    fetch('/wishlist/count')
        .then(response => response.json())
        .then(data => {
            const counter = document.querySelector('.wishlist-counter');
            if (counter && data.count !== undefined) {
                counter.textContent = data.count;
            }
        })
       // Tambahkan di bagian catch error pada tombol wishlist
.catch(error => {
    console.error('Full error:', error);
    console.error('Error message:', error.message);
    
    // Cek jika ada response dari server
    if (error.response) {
        console.error('Response status:', error.response.status);
        console.error('Response data:', error.response.data);
    }
    
    if (error.message.includes('401')) {
        showNotification('Silakan login terlebih dahulu', 'error');
    } else {
        showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
    }
})
}