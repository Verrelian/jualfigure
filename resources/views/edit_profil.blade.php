<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link href="stylee.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<style>
    /* Global Styles */
body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background-color: #1F1A4C;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #fff;
}

/* Container */
.container {
    background-color: #2D2C60;
    width: 100%;
    max-width: 400px;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease-in-out;
}

.container:hover {
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
}

/* Title */
.title {
    font-size: 24px;
    font-weight: 600;
    color: #fff;
    text-align: center;
    margin-bottom: 15px;
}

/* Content Section */
.content {
    margin-top: 20px;
    color: #f8f9fa;
    font-size: 14px;
}

.content p {
    margin: 8px 0;
}

/* Form Elements */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    color: #bbb;
    font-weight: 500;
    margin-bottom: 5px;
}

.form-group input {
    width: 93%;
    padding: 12px;
    font-size: 14px;
    border-radius: 8px;
    border: 1px solid #555;
    background-color: #414170;
    color: white;
    transition: all 0.3s ease-in-out;
}

.form-group input:focus {
    border: 1px solid #7f92e5;
    outline: none;
    background-color: #38344d;
}

/* Buttons */
.buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
    margin-top: 20px;
}

.buttons button,
.buttons a,
.save {
    border: none;
    border-radius: 8px;
    padding: 12px 20px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-decoration: none;
    text-align: center;
}

.buttons a {
    background-color: #410af4;
    color: white;
}

.buttons a:hover {
    background-color: #7f92e5;
}

.save {
    background-color: #2FE0FF;
    color: #1F1A4C;
    font-weight: bold;
    font-size: 16px;
}

.save:hover {
    background-color: #39d6f3;
}

/* Alert message */
.alert {
    color: #e74c3c;
    text-align: center;
    font-weight: 600;
    margin-top: 10px;
}

</style>
<body>
    <div class="container">
        <div class="title">
            Edit Profil
        </div>

        <div class="alert">
            <!-- Pesan error akan ditampilkan di sini jika ada -->
        </div>

        <form action="edit.php" method="POST">
            <input type="hidden" name="user_id" value="">

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" value="" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="" required>
            </div>

            <div class="buttons">
                <button type="submit" class="save">Save Changes</button>
                <a href="profile.php" class="cancel-button">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
