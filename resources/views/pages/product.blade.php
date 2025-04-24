@extends('layouts.app')

@section('title', 'Himura Kenshin Figure - Rurouni Kenshin')

@section('content')
    @include('components.back-button', ['backUrl' => route('home')])
    
    <div class="row mt-3">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-9">
                    <img src="{{ asset('images/products/kenshin-main.jpg') }}" alt="Himura Kenshin Figure" class="product-image-main">
                </div>
                <div class="col-3">
                    <img src="{{ asset('images/products/kenshin-thumbnail-1.jpg') }}" alt="Kenshin Side View" class="product-image-thumbnail">
                    <img src="{{ asset('images/products/kenshin-thumbnail-2.jpg') }}" alt="Kenshin Front View" class="product-image-thumbnail">
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="product-info">
                <h2>[Hanami SALE] PVC Non Scale Figure Himura Kenshin - Rurouni Kenshin</h2>
                <div class="price-tag">IDR 699,000</div>
                
                <div class="mb-3">
                    <label for="quantity">Quantity</label>
                    @include('components.quantity-control', ['quantity' => 1])
                </div>
                
                <div class="product-description">
                    <p>From "Rurouni Kenshin", the main character Kenshin Himura has been sculpted as a non-scale figure!</p>
                    <p>Kenshin is posed sitting on a chair with a gentle yet strong expression on his face.</p>
                    <p>Costumes are created by modeling the thickness and flexure of his clothing with a focus on texture.</p>
                    <p>Under special supervision every detail has been carefully considered.</p>
                    <p>Bring Kenshin Himura home at an affordable price and with a lot of attention to detail!</p>
                    <p>Painted plastic non-scale complete product. Approximately 155mm in height.</p>
                </div>
                
                <form action="{{ route('cart.add') }}" method="POST" id="buy-form">
                    @csrf
                    <input type="hidden" name="product_id" value="1">
                    <input type="hidden" name="product_name" value="Himura Kenshin Figure">
                    <input type="hidden" name="price" value="699000">
                    <button type="button" class="buy-now-btn" id="buy-now-btn">Buy It Now</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buyNowBtn = document.getElementById('buy-now-btn');
        
        if (buyNowBtn) {
            buyNowBtn.addEventListener('click', function() {
                document.getElementById('buy-form').submit();
            });
        }
        
        const wishlistBtn = document.querySelector('.wishlist-btn');
        if (wishlistBtn) {
            wishlistBtn.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (icon) {
                    if (icon.classList.contains('far')) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    }
                }
            });
        }
    });
</script>
@endpush
