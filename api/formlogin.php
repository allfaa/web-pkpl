<?php
session_start();  // Memulai sesi

// Koneksi ke database
$servername = "localhost"; // Ganti dengan host server Anda
$username = "root";        // Ganti dengan username MySQL Anda
$password = "";            // Ganti dengan password MySQL Anda
$dbname = "user_db";       // Nama database yang telah dibuat

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input dari form
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Query untuk memeriksa apakah username dan password cocok
    $sql = "SELECT * FROM users WHERE username = '$input_username' AND password = '$input_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Jika login berhasil, simpan status login dan redirect ke index.php
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $input_username;  // Menyimpan username di sesi
        echo "<script>
                alert('Login Berhasil');
                window.location.href = 'index.php';  // Redirect ke halaman index
              </script>";
        exit();
    } else {
        // Jika login gagal
        echo "<script>alert('Username atau password salah!');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Form Login</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url(https://www.pixelstalk.net/wp-content/uploads/2016/11/Earth-From-Space-HD-Backgrounds.jpg);
            background-size: 100%;
        }

        .center {
            width: 600px;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .login-form {
            width: 300px;
        }

        .petunjuk {
            color: red;
            font-size: 10px;
            margin-bottom: 10px;
        }

        .lupa-sandi {
            color: black;
            font-size: 10px;
            margin-bottom: 10px;
        }

        .signup_link {
            color: black;
            font-size: 13px;
            margin-bottom: 13px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .input-container {
            margin-bottom: 10px;
        }

        .input-container label {
            display: block;
            margin-bottom: 5px;
        }

        .input-container input {
            width: 100%;
            padding: 10px;
            margin: 0;
            border: none;
            border-bottom: 2px solid #ccc;
            border-radius: 0;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        input[name="submit"] {
            background: #007bff;
            color: white;
            padding: 10px;
            width: 100%;
            border-radius: 15px;
        }

        .info-image {
            width: 250px;
        }

        .info-image img {
            width: 100%;
            height: auto;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>

<body>
    <div class="center">
        <div class="login-form">
            <h1>Silahkan Login</h1>
            <br>
            <form id="loginForm" action="" method="POST" style="background-color: rgba(255, 255, 255, 0.5);">

                <div class="input-container">
                    <label for="username"></label>
                    <input type="text" id="username" name="username" placeholder="Masukan Email Anda">
                    <div id="usernameError" class="error-message">Email harus diisi dan harus menggunakan @gmail.com!
                    </div> <!-- Validasi untuk email -->
                </div>

                <div class="input-container">
                    <label for="password"></label>
                    <input type="password" id="password" name="password" placeholder="Kata Sandi"
                        oninput="checkPasswordLength()">
                    <div id="passwordError" class="error-message">Password tidak boleh kosong!</div>
                    <!-- Validasi untuk password kosong -->
                    <div id="password-note" class="note"
                        style="font-size: 12px; color: red; display: none; margin-top: 5px;">
                        Password tidak boleh lebih dari 12 karakter.
                    </div>
                </div>

                <script>
                    function checkPasswordLength() {
                        var passwordField = document.getElementById('password');
                        var note = document.getElementById('password-note');

                        // Cek apakah panjang password melebihi 12 karakter
                        if (passwordField.value.length > 12) {
                            note.style.display = 'block'; // Tampilkan pesan error
                        } else {
                            note.style.display = 'none'; // Sembunyikan pesan error
                        }
                    }

                    document.getElementById('loginForm').addEventListener('submit', function (event) {
                        var username = document.getElementById('username').value;
                        var password = document.getElementById('password').value;
                        var usernameError = document.getElementById('usernameError');
                        var passwordError = document.getElementById('passwordError');
                        var isValid = true;

                        // Reset error messages
                        usernameError.style.display = 'none';
                        passwordError.style.display = 'none';

                        // Validasi email
                        if (username.trim() === '') {
                            usernameError.style.display = 'block';
                            isValid = false;
                        } else if (!username.includes('@gmail.com')) {
                            usernameError.innerText = 'Email harus menggunakan @gmail.com';
                            usernameError.style.display = 'block';
                            isValid = false;
                        }

                        // Validasi password
                        if (password.trim() === '') {
                            passwordError.style.display = 'block';
                            isValid = false;
                        }

                        if (!isValid) {
                            event.preventDefault(); // Mencegah form dikirim jika ada error
                        }
                    });
                </script>

                <br>
                <input name="submit" type="submit" value="Masuk" width="100%">
                <br><br>
                <div class="lupa-sandi">Lupa kata sandi anda ?</div>
                <div class="lupa-sandi">Silahkan klik <a href="" style="color: #0056b3;"><b>URL ini</b></a> untuk
                    mereset kata sandi anda.</div>
                <br>
                <div class="signup_link">
                    Belum Punya Akun? <a href="registrasi.php">Daftar</a>
                </div>
            </form>
        </div>
        <div class="info-image">
            <img src="https://hailbytes.com/wp-content/uploads/2020/07/Login.gif" alt="Login Image">
        </div>
    </div>
</body>

</html>