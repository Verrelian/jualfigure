<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Figure Collection Store')</title>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Script -->
    <script src="/js/crud.js"></script>

    <!-- Scrollbar Hide Utility -->
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


    <!-- Flowbite CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="font-[Poppins] min-h-screen bg-gradient-to-b from-gray-100 via-gray-100 to-gray-230">

    <!-- Navbar -->
    @include('component.navbar')

    <!-- Banner (only shown if the child view has a @section('banner')) -->

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

    <!-- Wishlist Count Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function updateWishlistCount() {
                const el = document.getElementById('wishlistCount');
                if (el) {
                    const data = localStorage.getItem('wishlist');
                    const items = data ? JSON.parse(data) : [];
                    el.textContent = items.length;
                    el.classList.toggle('hidden', items.length === 0);
                }
            }

            updateWishlistCount();

            window.addEventListener('storage', function (e) {
                if (e.key === 'wishlist') updateWishlistCount();
            });
        });
    </script>
</body>
</html>
