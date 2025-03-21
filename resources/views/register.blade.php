<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="btc.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome/6.0.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(#282568, #4F49CE);
            color: white;
        }

        .logo {
            margin: 0px;
        }

        .logo img {
            width: 130px;
            height: auto;
            padding-left: 30px;
            padding-top: 30px;
        }

        .form-container {
            max-width: 600px;
            padding-left: 30px;
        }

        h1 {
            margin: 5px 0 20px;
            font-size: 32px;
            text-align: left;
        }

        .form-control {
            background-color: #D9D9D9 !important;
            border: none !important;
            color: black !important;
            border-radius: 50px !important;
            padding: 7px 20px !important;
            max-width: 400px;
            opacity: 90%;
        }

        .form-control::placeholder {
            color: #D9D9D9;
        }

        .form-control:focus {
            box-shadow: none !important;
        }

        .password-group {
            display: flex;
            gap: 50px;
            max-width: 900px;
        }

        .password-group .form-group {
            flex: 1;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-signup {
            background-color: #4CAF50;
            /* Hijau untuk valid */
            transition: background-color 0.3s ease;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 40px;
            width: 200px;
            font-weight: 500;
        }

        .btn-signup:disabled {
            background-color: #6f6e6e;
            /* Tetap abu-abu saat tidak aktif */
        }

        .btn-signup:hover {
            background-color: #6f6e6e;
            color: white;
        }

        .form-check {
            margin: 20px 0;
        }

        .login-link {
            color: #18FBFB;
            text-decoration: none;
        }

        .login-link:hover {
            color: #18FBFB;
        }

        .form-check-input {
            background-color: #FFFFFF;
            border: none;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-container {
            margin: 30px 0;
        }

        .login-text {
            margin-left: 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="logo">
        <img src="btc.png" alt="BTC Logo">
    </div>

    <div class="signup-container">
        <div class="form-container">
            <h1>Sign Up</h1>

            <form action="signup.php" method="POST" id="signupForm">
                <div class="form-group">
                    <label for="user" class="form-label">Username</label>
                    <input type="text" class="form-control" id="user" name="user" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="password-group">
                    <div class="form-group">
                        <label for="pass" class="form-label">Password</label>
                        <input type="password" class="form-control" id="pass" name="pass" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" required>
                    <label class="form-check-label">
                        I agree to this terms
                    </label>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn btn-signup">Sign Up</button>
                </div>
                <?php if (isset($error)): ?>
                <p class="message" style="color: #f44336;"><?= $error ?></p>
                <?php endif; ?>

                <div class="login-text">
                    Already have an account? <a href="login.php" class="login-link">Log In</a>
                </div>
            </form>

            <!-- Bootstrap JS and dependencies -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

            <script>
                    const form = document.getElementById('signupForm');
                    const inputs = form.querySelectorAll('input');
                    const submitButton = form.querySelector('.btn-signup');

                    // Menambahkan event listener pada setiap input untuk validasi dan Enter behavior
                    inputs.forEach((input, index) => {
                        input.addEventListener('input', checkFormValidity);

                        // Event listener untuk tombol Enter
                        input.addEventListener('keydown', (event) => {
                            if (event.key === 'Enter') {
                                event.preventDefault();
                                const nextInput = inputs[index + 1];
                                if (nextInput) {
                                    nextInput.focus();
                                }
                            }
                        });
                    });

                    function checkFormValidity() {
                        let isValid = form.checkValidity();
                        submitButton.disabled = !isValid; // Aktifkan/hentikan tombol
                    }

                    form.addEventListener('submit', function (e) {
                        const password = document.getElementById('pass').value;
                        const confirmPassword = document.getElementById('confirmPassword').value;

                        if (password !== confirmPassword) {
                            alert('Passwords do not match!');
                            e.preventDefault(); // Cegah pengiriman form
                        }
                        // Cek panjang password di sisi klien
                        if (password.length < 6) {
                            alert('Password harus memiliki minimal 6 karakter!');
                            e.preventDefault(); // Cegah pengiriman form
                        }
                    });

            </script>

</body>

</html>