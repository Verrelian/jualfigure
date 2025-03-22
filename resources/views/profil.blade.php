<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="btc.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet"> <!-- Menghubungkan CSS untuk halaman profil -->
</head>
<style>
    /* Gaya Global */
:root {
    --bg-gradient: linear-gradient(145deg, #1a1452, #2e2279);
    --card-bg: #726e99;
    --primary-text: #fff;
    --highlight-color: #00d7ff;
    --danger-bg: #ff4d4d;
    --danger-hover: #ff1a1a;
    --circle-bg: #4a4b82;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Montserrat', sans-serif;
}

body {
    background: var(--bg-gradient);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-size: 16px;
    color: var(--primary-text);
}

/* Kartu */
.card {
    background-color: var(--card-bg);
    border-radius: 15px;
    width: 480px;
    padding: 20px;
    position: relative;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

/* Lingkaran Profil */
.profile-circle {
    background-color: var(--circle-bg);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin: 15px auto;
    color: var(--primary-text);
    font-size: 2rem;
    font-weight: bold;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.username {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 15px;
}

/* Tombol */
.edit-btn,
.logout-btn,
.button-keluar {
    border: none;
    border-radius: 20px;
    font-weight: bold;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.edit-btn {
    position: absolute;
    top: 15px;
    right: 15px;
    background: var(--highlight-color);
    color: #000;
    padding: 8px 15px;
}

.edit-btn:hover {
    opacity: 0.8;
    transform: translateY(-2px);
}

.logout-btn {
    width: 100%;
    margin-top: 30px;
    padding: 12px;
    font-size: 1.1rem;
    background-color: var(--danger-bg);
    color: var(--primary-text);
    text-align: center;
}

.logout-btn:hover {
    background-color: var(--danger-hover);
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

.button-keluar {
    position: absolute;
    bottom: 15px;
    left: 15px;
    padding: 12px 25px;
    font-size: 1rem;
    color: var(--primary-text);
    background-color: var(--danger-bg);
}

.button-keluar:hover {
    background-color: var(--danger-hover);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
}

.button-keluar:active {
    background-color: #cc0000;
    transform: translateY(0);
}

/* Informasi Profil */
.profile-info {
    margin-top: 20px;
    text-align: left;
    padding: 0 20px;
}

.profile-item {
    font-size: 1rem;
    margin-bottom: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.profile-item span:first-child {
    font-weight: bold;
    min-width: 100px;
}

.profile-item span:last-child {
    flex-grow: 1;
    word-break: break-word;
    text-align: left;
}

</style>
<body>
    <div class="card">
        <!-- Tombol Edit -->
        <a href="edit_profil"><button class="edit-btn">Edit</button></a> <!-- Link menuju halaman edit -->

        <!-- Lingkaran Foto Profil dengan Inisial -->
        <div class="profile-circle">
            <!-- Inisial pengguna akan ditampilkan di sini -->
        </div>

        <!-- Menampilkan Username Pengguna -->
        <div class="username">
            <!-- Username pengguna akan ditampilkan di sini -->
        </div>

        <div class="profile-info">
            <div class="profile-item">
                <span>User ID</span>
                <span>: </span>
            </div>
            <div class="profile-item">
                <span>Email</span>
                <span>: </span>
            </div>
        </div>

        <!-- Tombol Log Out -->
        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn">Log Out</button> <!-- Tombol untuk logout -->
        </form>
    </div>

    <!-- Tombol Keluar yang diletakkan di pojok kiri bawah -->
    <a href="dashboard.php" class="button-keluar">Leave</a> <!-- Tombol untuk kembali ke dashboard -->
</body>
</html>