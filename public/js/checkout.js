// Payment selection function
function selectPayment(method) {
    const radio = document.querySelector(`input[value="${method}"]`);
    if (radio) {
        radio.checked = true;
        updateTotal();
    }
}

// Quantity increase function
function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    if (!quantityInput) return;

    const max = parseInt(quantityInput.max);
    let current = parseInt(quantityInput.value);

    if (current < max) {
        quantityInput.value = current + 1;
        updateSubtotalOnly();
    }
}

// Quantity decrease function
function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    if (!quantityInput) return;

    if (parseInt(quantityInput.value) > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
        updateSubtotalOnly();
    }
}

// Update subtotal only (for quantity changes)
function updateSubtotalOnly() {
    const quantityInput = document.getElementById('quantity');
    const subtotalEl = document.getElementById('subtotal');
    if (!quantityInput || !subtotalEl) return;

    const quantity = parseInt(quantityInput.value) || 1;
    const subtotal = checkoutData.productPrice * quantity;
    subtotalEl.textContent = `IDR ${subtotal.toLocaleString()}`;
}

// Update total calculation
function updateTotal() {
    const quantity = parseInt(document.getElementById('quantity')?.value || 1);
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;
    const checkoutBtn = document.getElementById('checkoutBtn');

    let subtotal = 0;
    if (checkoutData.isCart) {
        subtotal = checkoutData.subtotalCart;
    } else {
        subtotal = checkoutData.productPrice * quantity;
    }

    const tax = 50000;
    const shipping = 100000;
    let bankCharge = 0;

    // Calculate bank charge based on payment method
    switch (paymentMethod) {
        case 'BANK BCA':
            bankCharge = 350000;
            break;
        case 'BANK MANDIRI':
            bankCharge = 300000;
            break;
        case 'BANK BNI':
            bankCharge = 260000;
            break;
        case 'BANK BRI':
            bankCharge = 250000;
            break;
        default:
            // No payment method selected
            document.getElementById('tax').textContent = "-";
            document.getElementById('shipping').textContent = "-";
            document.getElementById('bankCharge').textContent = "-";
            document.getElementById('total').textContent = "-";
            checkoutBtn.disabled = true;
            return;
    }

    const total = subtotal + tax + shipping + bankCharge;

    // Update UI elements
    document.getElementById('subtotal').innerText = `IDR ${subtotal.toLocaleString()}`;
    document.getElementById('tax').innerText = `IDR ${tax.toLocaleString()}`;
    document.getElementById('shipping').innerText = `IDR ${shipping.toLocaleString()}`;
    document.getElementById('bankCharge').innerText = `IDR ${bankCharge.toLocaleString()}`;
    document.getElementById('total').innerText = `IDR ${total.toLocaleString()}`;

    // Enable checkout button
    checkoutBtn.disabled = false;
}

// Initialize when DOM is loaded
window.addEventListener('DOMContentLoaded', function() {
    // Initial calculation
    updateTotal();

    // Add event listeners for payment method changes
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', updateTotal);
    });

    // Add event listener for form submission
    const form = document.getElementById('checkoutForm');
    if (form) {
        form.addEventListener('submit', function() {
            updateTotal();
        });
    }
});