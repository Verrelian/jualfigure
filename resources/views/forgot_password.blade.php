<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="btc.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <!-- Flowbite + Tailwind c -->
    <link href="https://cdn.tailwindcss.com" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-b from-[#282568] to-[#4F49CE] flex items-center justify-center">

    <!-- Logo -->
    <img src="btc.png" alt="BTC Logo" class="w-24 h-auto absolute top-5 left-5">

    <!-- Form Container -->
    <div class="bg-white bg-opacity-90 rounded-xl shadow-lg p-8 w-full max-w-md text-center">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Forgot Password?</h1>

        <form method="POST" action="">
            <div class="mb-4 text-left">
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" placeholder="Masukkan Username Anda" required
                       class="w-full mt-1 px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            <div class="mb-4 text-left">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" placeholder="Masukkan Email Anda" required
                       class="w-full mt-1 px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            <button type="submit"
                    class="bg-gray-800 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-full transition duration-300 w-full">
                Next
            </button>
        </form>

        <?php if (isset($error)): ?>
            <p class="text-red-600 mt-4"><?= $error ?></p>
        <?php endif; ?>
    </div>

</body>
</html>
