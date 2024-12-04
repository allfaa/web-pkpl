<?php
session_start();  // Memulai sesi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Arahkan pengguna ke halaman login jika belum login
    header("Location: formlogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Barang</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Navbar -->
    <nav>
        <div>
            <a href="javascript:void(0);" onclick="scrollToSection('home')">Home</a>
            <a href="javascript:void(0);" onclick="scrollToSection('produk')">Produk</a>
            <a href="javascript:void(0);" onclick="scrollToSection('pesanan')">Pesanan</a>
            <a href="javascript:void(0);" onclick="scrollToSection('About')">About</a>

            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true): ?>
                <a href="profil.php">Profil</a> <!-- Ganti "Profil" ketika login -->
            <?php else: ?>
                <a href="formlogin.php">Login</a> <!-- Tautan Login ketika belum login -->
            <?php endif; ?>
        </div>

        <!-- Form Pencarian -->
        <form method="GET" id="searchForm">
            <input type="text" name="search" id="searchInput" placeholder="Cari barang..." />
            <div>
                <img src="icon/cart.png" class="icon" onclick="togglePopup('cartPopup')" alt="Cart">
                <img src="icon/fav.png" class="icon" onclick="togglePopup('wishlistPopup')" alt="Wishlist">
            </div>
        </form>
    </nav>

    <!-- Home Section -->
    <section id="home">
        <h1>Selamat datang di Toko Kami</h1>
        <p>Temukan berbagai barang kebutuhan sehari-hari di sini.</p>
    </section>

    <!-- Produk Section -->
    <section id="produk">
        <h1>Produk Kami</h1>

        <!-- Hasil pencarian produk akan muncul di sini -->
        <div id="searchResultsPopup" class="popup">
            <div class="popup-content">
                <span class="close-btn" onclick="closePopup()">&times;</span>
                <h3>Hasil Pencarian</h3>
                <div id="searchResults"></div>
            </div>
        </div>

        <?php
        // Koneksi database
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $database = 'toko';
        $conn = new mysqli($host, $user, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Pencarian produk
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $sql = "SELECT * FROM barang WHERE nama_barang LIKE '%$search%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='product-container'>
                    <h3>{$row['nama_barang']}</h3>
                    <p class='product-price'>Rp {$row['harga']}</p>
                    <p class='product-stock'>Stok: {$row['stok']}</p>
                    <div class='product-icons'>
                        <span onclick=\"addToCart('{$row['nama_barang']}')\">🛒</span>
                        <span onclick=\"addToWishlist('{$row['nama_barang']}')\">💖</span>
                    </div>
                </div>
                ";
            }
        } else {
            echo "<p>Tidak ada barang yang ditemukan.</p>";
        }

        $conn->close();
        ?>
    </section>

    <!-- Pesanan Section -->
    <section id="pesanan">
        <h1>Pesanan Anda</h1>
        <p>Halaman ini menampilkan daftar pesanan Anda yang telah dibuat.</p>
    </section>

    <!-- About Section -->
    <section id="About">
        <h1>About Pengguna</h1>
        <p>Informasi About Anda ditampilkan di sini.</p>
    </section>

    <!-- Cart Popup -->
    <div id="cartPopup" class="popup">
        <h2>Keranjang Belanja</h2>
        <ul id="cartItems">
            <!-- Daftar barang dalam keranjang -->
        </ul>
        <button class="close" onclick="togglePopup('cartPopup')">Tutup</button>
    </div>

    <!-- Wishlist Popup -->
    <div id="wishlistPopup" class="popup">
        <h2>Wishlist</h2>
        <ul id="wishlistItems">
            <!-- Daftar barang dalam wishlist -->
        </ul>
        <button class="close" onclick="togglePopup('wishlistPopup')">Tutup</button>
    </div>

    <script>
        let cart = [];
        let wishlist = [];

        // Fungsi menambahkan item ke keranjang
        function addToCart(item) {
            cart.push(item);
            alert(item + " telah ditambahkan ke keranjang.");
            updateCartPopup();
        }

        // Fungsi menambahkan item ke wishlist
        function addToWishlist(item) {
            wishlist.push(item);
            alert(item + " telah ditambahkan ke wishlist.");
            updateWishlistPopup();
        }

        // Update popup keranjang belanja
        function updateCartPopup() {
            const cartItems = document.getElementById('cartItems');
            cartItems.innerHTML = '';
            cart.forEach((item, index) => {
                const li = document.createElement('li');
                li.textContent = item;
                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Hapus';
                removeBtn.onclick = () => removeFromCart(index);
                li.appendChild(removeBtn);
                cartItems.appendChild(li);
            });
        }

        // Update popup wishlist
        function updateWishlistPopup() {
            const wishlistItems = document.getElementById('wishlistItems');
            wishlistItems.innerHTML = '';
            wishlist.forEach((item, index) => {
                const li = document.createElement('li');
                li.textContent = item;
                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Hapus';
                removeBtn.onclick = () => removeFromWishlist(index);
                li.appendChild(removeBtn);
                wishlistItems.appendChild(li);
            });
        }

        // Fungsi menghapus item dari keranjang
        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCartPopup();
        }

        // Fungsi menghapus item dari wishlist
        function removeFromWishlist(index) {
            wishlist.splice(index, 1);
            updateWishlistPopup();
        }

        // Fungsi untuk toggle popup (keranjang dan wishlist)
        function togglePopup(popupId) {
            const popup = document.getElementById(popupId);
            popup.classList.toggle('open');
        }

        // Fungsi untuk scroll ke bagian tertentu
        function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            section.scrollIntoView({ behavior: 'smooth' });
        }

        // Fungsi untuk membuka popup pencarian hasil
        function openPopup() {
            document.getElementById('searchResultsPopup').style.display = 'block';
        }

        // Fungsi untuk menutup popup pencarian hasil
        function closePopup() {
            document.getElementById('searchResultsPopup').style.display = 'none';
        }

        // Menampilkan hasil pencarian dalam popup
        function displaySearchResults(data) {
            const resultsContainer = document.getElementById('searchResults');
            resultsContainer.innerHTML = '';  // Clear previous results

            if (data.length > 0) {
                data.forEach(item => {
                    const resultItem = document.createElement('div');
                    resultItem.classList.add('product-container');
                    resultItem.innerHTML = `
                        <h3>${item.nama_barang}</h3>
                        <p class='product-price'>Rp ${item.harga}</p>
                        <p class='product-stock'>Stok: ${item.stok}</p>
                        <div class='product-icons'>
                            <span onclick="addToCart('${item.nama_barang}')">🛒</span>
                            <span onclick="addToWishlist('${item.nama_barang}')">💖</span>
                        </div>
                    `;
                    resultsContainer.appendChild(resultItem);
                });
            } else {
                resultsContainer.innerHTML = '<p>Tidak ada hasil ditemukan.</p>';
            }
        }

        // AJAX untuk pencarian produk
        document.getElementById('searchForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const query = document.getElementById('searchInput').value;

            if (query) {
                fetch(`search.php?q=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        displaySearchResults(data);
                        openPopup();
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>

</body>

</html>