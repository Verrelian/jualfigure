<div class="quantity-control">
    <button type="button" class="decrease-quantity" aria-label="Decrease quantity">-</button>
    <input type="number" name="quantity" value="{{ $quantity ?? 1 }}" min="1" max="99" readonly>
    <button type="button" class="increase-quantity" aria-label="Increase quantity">+</button>
    <button type="button" class="wishlist-btn" aria-label="Add to wishlist">
        <i class="far fa-bookmark"></i>
    </button>
</div>

@once
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const decreaseBtn = document.querySelector('.decrease-quantity');
            const increaseBtn = document.querySelector('.increase-quantity');
            const quantityInput = document.querySelector('input[name="quantity"]');
            
            if (decreaseBtn && increaseBtn && quantityInput) {
                decreaseBtn.addEventListener('click', function() {
                    const currentValue = parseInt(quantityInput.value);
                    if (currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                    }
                });
                
                increaseBtn.addEventListener('click', function() {
                    const currentValue = parseInt(quantityInput.value);
                    if (currentValue < 99) {
                        quantityInput.value = currentValue + 1;
                    }
                });
            }
        });
    </script>
    @endpush
@endonce