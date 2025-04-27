<div class="quantity-control">
    <button type="button" class="decrease-quantity" aria-label="Decrease quantity">-</button>
    <input type="number" name="quantity" value="{{ $quantity ?? 1 }}" min="1" max="99" readonly>
    <button type="button" class="increase-quantity" aria-label="Increase quantity">+</button>
    <button type="button" class="wishlist-btn" aria-label="Add to wishlist">
        <i class="far fa-bookmark"></i>
    </button>
</div>