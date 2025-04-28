<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
</head>
<body class="bg-gray-100">

    @include('parts.navbar')
    <div class="flex">
        @include('parts.sidebar')

        <main class="p-6 w-full">
            @yield('content')
        </main>
    </div>

</body>
</html>
