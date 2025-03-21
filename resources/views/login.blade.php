<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="btc.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
<style>
    body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(to bottom, #1a1a5c, #2c2c6c);
    color: #fff;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-box {
    background: #202040;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    width: 400px;
}

.login-box h2 {
    margin: 0 0 20px;
    text-align: left;
}

label {
    display: block;
    margin: 10px 0 5px;
}

input, select {
    width: 95%;
    padding: 10px;
    margin-bottom: 15px;
    border: none;
    border-radius: 5px;
}

input[type="checkbox"] {
    width: auto;
    margin-right: 5px;
}

button {
    background-color: #5a5aff;
    color: #fff;
    border: none;
    padding: 10px;
    width: 100%;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #4444ff;
}

.link {
    text-align: center;
    margin-top: 10px;
}

.link a {
    color: cyan;
    text-decoration: none;
}

.error {
    color: red;
    margin-bottom: 10px;
}

</style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>Log In</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; // Menampilkan pesan error jika ada ?>
            <form method="POST" action="">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>">
                <!-- Jika username disimpan dalam cookie, tampilkan sebagai default value -->

                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>

                <label for="type_user">User Type</label>
                <select name="type_user" id="type_user" required>
                    <option value="penjual" <?php if(isset($_COOKIE['type_user']) && $_COOKIE['type_user'] == 'penjual') echo 'selected'; ?>>Penjual</option>
                    <option value="pembeli" <?php if(isset($_COOKIE['type_user']) && $_COOKIE['type_user'] == 'pembeli') echo 'selected'; ?>>Pembeli</option>
                </select>

                <label>
                    <input type="checkbox" name="remember" <?php if(isset($_COOKIE['username'])) echo 'checked'; ?>> Remember me
                </label>

                <button type="submit" name="login">Log In</button>
            </form>
            <div class="link">
                <p><a href="forgot_password.php">Forgot Password?</a></p> <!-- Link untuk lupa password -->
                <p>Don’t have an account? <a href="signup.php">Sign Up</a></p> <!-- Link ke halaman daftar -->
            </div>
        </div>
    </div>
</body>
</html>