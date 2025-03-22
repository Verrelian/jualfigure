<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="btc.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - PUBG Top Up</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="style_penjual.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>
<style>
    
body {
    background-color: #283593;
}

.menu-icon {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 20px;
    height: 21px;
    cursor: pointer;
    margin-right: 40px;
    margin-left: 10px;
}

.menu-icon div {
    width: 150%;
    height: 3px;
    background-color: #ffffff;
    border-radius: 2px;
}

header {
    display: flex;
    align-items: center;
    background-color: #1a2373;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 999;
    width: 100%;
    padding: 10px 20px;
    gap: 20px;
}

.header-menu-btn {
    position: relative;
    z-index: 1000;
    color: white;
    font-size: 32px;
    padding: 8px 10px;
    line-height: 1;
    border: none;
    background: transparent;
    transition: transform 0.2s;
    margin-top: 0px;
    display: flex;
    align-items: center;
    cursor: pointer;
}

.header-menu-btn:hover {
    transform: scale(1.1);
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
}

.header-left {
    display: flex;
    align-items: center;
}

.header-logo img {
    width: 90px;
    height: auto;
}

@media (max-width: 768px) {
    .header-menu-btn {
        font-size: 28px;
        padding: 6px 12px;
        margin-top: 10px;
    }

    .header-logo img {
        width: 90px;
    }
}

@media (max-width: 576px) {
    .header-menu-btn {
        font-size: 24px;
        padding: 4px 10px;
        margin-top: 8px;
    }

    .header-logo img {
        width: 80px;
    }
}

.custom-offcanvas {
    background-color: #1a2373;
    color: white;
    padding-left: 20px;
}

.logo {
    width: 145px;
    height: auto;
    padding-left: 23px;
    padding-top: 20px;
}

.nav-link {
    font-size: 1.5rem;
    font-weight: normal;
    text-align: left;
    color: white;
}

.offcanvas-header .btn-close {
    color: white;
}

.offcanvas-body {
    display: flex;
    flex-direction: column;
    align-items: start;
}

.header-image {
    height: 300px;
    object-fit: cover;
    width: 100%;
}

.game-logo {
    width: 130px;
    height: 180px;
    margin-top: -90px;
    margin-left: -20px;
    border-radius: 8px;
}

.main-content {
    background-color: #283593;
    border-radius: 8px;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.product-card {
    background-color: rgba(217, 217, 217, 0.3);
    transition: all 0.3s;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 150px;
    padding: 1rem;
    border-radius: 8px;
    font-size: 18px;
    text-align: center;
}

.product-card:hover {
    background-color: #425AAE;
    cursor: pointer;
    color: white;
}

.product-card img {
    width: 70px;
    height: 70px;
    object-fit: contain;
    margin: 0 auto;
}

.edit-button {
    margin-top: 10px;
    background-color: #5B8FF5;
    color: white;
    border: none;
    border-radius: 50px;
    padding: 5px 10px;
    font-size: 14px;
    transition: background-color 0.3s;
}

.edit-button:hover {
    background-color: #425AAE;
}

footer {
    text-align: center;
    padding: 10px;
    background-color: #5C6BC0;
    color: #ffffff;
    font-size: 14px;
}

footer .footer-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}

footer .footer-logo img {
    width: 90px;
    height: auto;
    margin-left: 10px;
}

footer .footer-text p {
    margin-bottom: 5px;
}

</style>
<body>

    <!-- Header Section -->
    <header class="header">
        <button class="header-menu-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu"
            aria-controls="offcanvasMenu">
            ☰
        </button>
        <div class="header-left">
            <div class="header-logo">
                <a href="dashboard_penjual.php">
                    <img src="btc.png" alt="BTC Logo">
                </a>
            </div>
        </div>
    </header>

    <div class="offcanvas offcanvas-start custom-offcanvas" tabindex="-1" id="offcanvasMenu"
        aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel"><img src="btc.png" class="logo"></h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
                <li class="nav-item"><a href="produk1_penjual.php" class="nav-link text-white">PUBG</a></li>
                <li class="nav-item"><a href="produk2_penjual.php" class="nav-link text-white">MOBILE LEGEND</a></li>
                <li class="nav-item"><a href="produk3_penjual.php" class="nav-link text-white">FREE FIRE</a></li>
            </ul>
        </div>
    </div>

    <div class="position-relative">
        <img src="pubg_banner.jpg" alt="PUBG Characters Banner" class="header-image">
    </div>
    <div class="container position-relative">
        <div class="d-flex align-items-end mb-4">
            <img src="pubg.jpg" alt="PUBG Logo" class="game-logo">
            <div class="text-white ms-3 mb-4">
                <h1 class="fs-2 fw-bold mb-0">PUBG</h1>
                <p class="fs-5 mb-2">TENCENT GAMES</p>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataLabel">Tambah Data Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="tambah_produk1.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama" name="nama_produk" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Produk</label>
                            <input type="text" class="form-control" id="harga" name="harga_produk" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-stok" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="edit-stok" name="stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-gambar" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="edit-gambar" name="gambar_produk" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content text-white p-4 mb-4">
        <h3 class="fw-bold fs-5 mb-3">Edit Produk</h3>
        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
            <i class="fas fa-plus-circle me-2"></i>TAMBAH DATA PRODUK
        </button>
        <div class="products-grid">
           
                    <div class="product-card">
                        <img src="" alt="Produk" class="img-fluid">
                        <div class="fw-bold mt-2"></div>
                        <div class="text-white-help">Rp </div>
                        <div class="text-white-help">Stock : </div>
                        <button class="btn edit-button" data-bs-toggle="modal" data-bs-target="#editDataModal"
                            data-id="" data-nama=""
                            data-harga=""
                            data-gambar="">Edit</button>
                        <a href="hapus_produk1.php?id=" class="btn btn-danger mt-2"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                    </div>
            
            
        </div>
    </div>


    <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataLabel">Edit Data Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="edit_produk1_penjual.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="edit-id" name="id_produk">
                        <div class="mb-3">
                            <label for="edit-nama" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="edit-nama" name="nama_produk" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-harga" class="form-label">Harga Produk</label>
                            <input type="text" class="form-control" id="edit-harga" name="harga_produk" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-stok" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="edit-stok" name="stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-gambar" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="edit-gambar" name="gambar_produk">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <img src="btc.png" alt="BTC Logo">
            </div>
            <div class="footer-text">
                <p>Nikmati kemudahan top-up diamond game favorit Anda menggunakan BTC Top Up Game Store!</p>
            </div>
        </div>
        <p>© 2025 BTC Top Up Game Store. All Rights Reserved.</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-button');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    try {
                        const id = this.getAttribute('data-id');
                        const nama = this.getAttribute('data-nama');
                        const harga = this.getAttribute('data-harga');
                        const stok = this.getAttribute('data-stok');
                        const gambar = this.getAttribute('data-gambar');

                        console.log('Product ID:', id);
                        console.log('Product Name:', nama);
                        console.log('Product Price:', harga);

                        const editIdInput = document.getElementById('edit-id');
                        const editNamaInput = document.getElementById('edit-nama');
                        const editHargaInput = document.getElementById('edit-harga');
                        const editStokInput = document.getElementById('edit-stok');
                        const gambarPreview = document.getElementById('gambar-preview');

                        if (editIdInput) {
                            editIdInput.value = id;
                        } else {
                            throw new Error('Edit ID input not found');
                        }

                        if (editNamaInput) {
                            editNamaInput.value = nama;
                        } else {
                            throw new Error('Edit Name input not found');
                        }

                        if (editHargaInput) {
                            editHargaInput.value = harga;
                        } else {
                            throw new Error('Edit Price input not found');
                        }

                        if (gambarPreview) {
                            gambarPreview.src = gambar ? gambar : 'default_image.jpg'; // Menampilkan gambar sebelumnya atau default jika tidak ada
                        }

                    } catch (error) {
                        // Menangani error jika terjadi, misalnya elemen tidak ditemukan
                        console.error('Error:', error.message);
                        alert('Terjadi kesalahan: ' + error.message); // Memberikan informasi kepada pengguna
                    }
                });
            });
        });
    </script>

</body>

</html>