<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mainan yang Dibeli</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">Mainan yang Telah Dibeli</h1>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach (['Golden Toy', 'Emerald', 'Wizard'] as $toy)
                <div class="bg-white p-4 rounded-lg shadow flex flex-col items-center">
                    <div class="w-16 h-16 bg-gray-200 rounded-full mb-2"></div>
                    <p class="text-sm">{{ $toy }}</p>
                </div>
            @endforeach
        </div>

        <a href="/mole/user/profile">
            <button class="mt-6 bg-black text-white px-4 py-2 rounded text-sm">← Kembali ke Profil</button>
        </a>
    </div>
</body>
</html>
