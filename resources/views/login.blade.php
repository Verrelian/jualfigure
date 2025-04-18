<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <link rel="icon" href="btc.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="m-0 font-sans bg-gradient-to-b from-[#1a1a5c] to-[#2c2c6c] text-white min-h-screen flex items-center justify-center">
  <div class="bg-[#202040] p-8 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-semibold mb-5">Log In</h2>

    <?php if (isset($error)) echo "<p class='text-red-500 mb-3'>$error</p>"; ?>

    <form method="POST" action="">
      <label for="username" class="block mb-1">Username</label>
      <input
        type="text"
        name="username"
        id="username"
        required
        value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>"
        class="w-full px-3 py-2 mb-4 rounded-md text-black"
      >

      <label for="password" class="block mb-1">Password</label>
      <input
        type="password"
        name="password"
        id="password"
        required
        class="w-full px-3 py-2 mb-4 rounded-md text-black"
      >

      <label for="type_user" class="block mb-1">User Type</label>
      <select
        name="type_user"
        id="type_user"
        required
        class="w-full px-3 py-2 mb-4 rounded-md text-black"
      >
        <option value="penjual" <?php if(isset($_COOKIE['type_user']) && $_COOKIE['type_user'] == 'penjual') echo 'selected'; ?>>Penjual</option>
        <option value="pembeli" <?php if(isset($_COOKIE['type_user']) && $_COOKIE['type_user'] == 'pembeli') echo 'selected'; ?>>Pembeli</option>
      </select>

      <label class="flex items-center mb-4">
        <input
          type="checkbox"
          name="remember"
          class="mr-2"
          <?php if(isset($_COOKIE['username'])) echo 'checked'; ?>
        > Remember me
      </label>

      <button
        type="submit"
        name="login"
        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md w-full"
      >
        Log In
      </button>
    </form>

    <div class="text-center mt-4 text-sm">
      <p><a href="forgot_password.php" class="text-cyan-400 hover:underline">Forgot Password?</a></p>
      <p class="mt-2">Don’t have an account? <a href="signup.php" class="text-cyan-400 hover:underline">Sign Up</a></p>
    </div>
  </div>
</body>
</html>
