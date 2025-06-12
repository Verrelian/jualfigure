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

    const wishlistBtn = document.getElementById('wishlistBtn');
    const heartIcon = document.getElementById('heartIcon');

    if (wishlistBtn && heartIcon) {
        const productId = wishlistBtn?.dataset.productId;
        const productTitle = wishlistBtn?.dataset.title;
        const productImage = wishlistBtn?.dataset.image;
        const productPrice = wishlistBtn?.dataset.price;
        const productType = wishlistBtn?.dataset.type;
        const productManufacture = wishlistBtn?.dataset.manufacture;

        function showNotification(message, isSuccess = true) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-4 py-2 rounded-md shadow-lg z-50 transition-opacity duration-300 ${isSuccess ? 'bg-gray-800 text-white' : 'bg-red-500 text-white'}`;
            notification.innerText = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        function isInWishlist(productId) {
            const wishlist = getWishlist();
            return wishlist.some(item => item.product_id === productId);
        }

        function getWishlist() {
            const wishlistData = localStorage.getItem('wishlist');
            return wishlistData ? JSON.parse(wishlistData) : [];
        }

        function saveWishlist(wishlist) {
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            updateWishlistCount();
        }

        function updateWishlistCount() {
            const wishlist = getWishlist();
            const wishlistCountElement = document.getElementById('wishlistCount');
            if (wishlistCountElement) {
                wishlistCountElement.textContent = wishlist.length;
            }
        }

        function toggleWishlist() {
            const wishlist = getWishlist();
            const productInWishlist = isInWishlist(productId);

            if (productInWishlist) {
                const updatedWishlist = wishlist.filter(item => item.product_id !== productId);
                saveWishlist(updatedWishlist);
                updateHeartIcon(false);
                showNotification(`${productTitle} removed from wishlist`);
            } else {
                const product = {
                    product_id: productId,
                    title: productTitle,
                    price: productPrice,
                    image: productImage,
                    type: productType,
                    isWishlisted: true,
                    specifications: {
                        Manufacture: productManufacture
                    }
                };
                wishlist.push(product);
                saveWishlist(wishlist);
                updateHeartIcon(true);
                showNotification(`${productTitle} added to wishlist`);
            }
        }

        function updateHeartIcon(isWishlisted) {
            if (isWishlisted) {
                heartIcon.setAttribute('fill', 'currentColor');
                heartIcon.style.color = '#e53e3e';
            } else {
                heartIcon.setAttribute('fill', 'none');
                heartIcon.style.color = '';
            }
        }

        if (productId) {
            updateHeartIcon(isInWishlist(productId));
        }

        updateWishlistCount();

        wishlistBtn.addEventListener('click', toggleWishlist);
    }
});
