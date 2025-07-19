<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Figure Collection Store')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Flowbite -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />

    <!-- Custom Script -->
    <script src="/js/crud.js"></script>

    <!-- Scrollbar Hide -->
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="font-[Poppins] min-h-screen bg-gradient-to-b from-gray-100 via-gray-100 to-gray-230">

    <!-- Toast Notification -->
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-show="show"
         x-transition
         x-init="$watch('show', value => { if (value) setTimeout(() => show = false, 3000) })"
         class="fixed top-5 right-5 z-50 max-w-xs rounded-lg px-4 py-3 text-white"
         :class="{
             'bg-green-500': type === 'success',
             'bg-red-500': type === 'error',
             'bg-yellow-500': type === 'warning'
         }">
        <p x-text="message"></p>
    </div>

    <!-- Navbar -->
    @include('component.navbar')

    <!-- Banner -->
    @hasSection('banner')
        <div class="relative w-full h-64 md:h-96 lg:h-[28rem]">
            <div class="w-full bg-white shadow-md mb-10 relative h-full">
                @yield('banner')
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="w-full max-w-7xl mx-auto px-4 md:px-8">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('component.footer')

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>


    <!-- Wishlist Count -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const el = document.getElementById('wishlistCount');
            if (el) {
                const data = localStorage.getItem('wishlist');
                const items = data ? JSON.parse(data) : [];
                el.textContent = items.length;
                el.classList.toggle('hidden', items.length === 0);
            }

            window.addEventListener('storage', function (e) {
                if (e.key === 'wishlist') {
                    const data = localStorage.getItem('wishlist');
                    const items = data ? JSON.parse(data) : [];
                    el.textContent = items.length;
                    el.classList.toggle('hidden', items.length === 0);
                }
            });
        });
    </script>

    <!-- Shipping Progress -->
    <script>
        let shippingInterval = null;
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = @json(csrf_token());

            function fetchActiveShippingOrders() {
                fetch('/mole/shipping/active')
                    .then(res => res.json())
                    .then(data => {
                        if (!data.shipping_orders || data.shipping_orders.length === 0) {
                            if (shippingInterval) {
                                clearInterval(shippingInterval);
                                shippingInterval = null;
                            }
                            return;
                        }

                        data.shipping_orders.forEach(order => {
                            const paymentId = order.payment_id;
                            fetch(`/mole/shipping/progress-data/${paymentId}`)
                                .then(res => res.json())
                                .then(progress => {
                                    if (progress.diff >= 5) {
                                        fetch(`/mole/shipping/next-stage/${paymentId}`, {
                                            method: 'POST',
                                            headers: { 'X-CSRF-TOKEN': csrfToken }
                                        })
                                        .then(res => res.json())
                                        .then(updated => {
                                            if (updated.delivered === true) {
                                                location.reload();
                                            }
                                        });
                                    }
                                });
                        });
                    });
            }

            if (!shippingInterval) {
                shippingInterval = setInterval(fetchActiveShippingOrders, 3000);
            }
        });
    </script>

    <!-- Toast Trigger Helper -->
    <script>
        function showToast(type, message) {
            const toast = document.querySelector('[x-data]');
            if (!toast) return;

            const alpine = Alpine;
            if (alpine && toast.__x) {
                toast.__x.$data.type = type;
                toast.__x.$data.message = message;
                toast.__x.$data.show = true;
            }
        }

        // Contoh:
        // showToast('success', 'Berhasil menambahkan komentar!');
        // showToast('error', 'Gagal menyukai postingan.');
    </script>
</body>

</html>
