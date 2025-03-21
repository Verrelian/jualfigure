<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="btc.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .gradient-background {
            background: linear-gradient(180deg, #282568 0%, #4F49CE 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .logo {
            width: 100px;
            height: auto;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .custom-input {
            border-radius: 50px;
            padding: 10px 12px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .custom-button {
            background: #424242;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
        }

        .custom-button:hover {
            background-color: #555555;
        }

        .page-title {
            color: white;
            font-size: 2.5rem;
            font-weight: 600;
        }

        .input-label {
            color: white;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="gradient-background">
        <img src="btc.png" alt="BTC Logo" class="logo">
        <div class="container text-center">
        <div class="container text-center mt-5">
        <h1>Forgot Password?</h1>
        <form method="POST" action="">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan Username Anda" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Masukkan Email Anda" required>
    </div>
    <button type="submit" class="btn btn-primary">Next</button>
</form>

        <?php if (isset($error)): ?>
            <p class="text-danger mt-3"><?= $error ?></p>
        <?php endif; ?>
    </div>
</form>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
