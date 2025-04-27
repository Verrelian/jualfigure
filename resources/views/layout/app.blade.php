<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Figure Collection Store')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Flowbite CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="min-h-screen p-4" style="background: linear-gradient(to bottom, #C5C4C0, #777284);">
   <!-- navbar -->
    @include('component.navbar')
    

    <!-- Main Content -->
    <main class="container mx-auto p-4">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('component.footer')
    
    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body>
</html>