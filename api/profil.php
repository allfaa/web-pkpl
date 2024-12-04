<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true) {
    header('Location: formlogin.php');  // Redirect ke halaman login jika belum login
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <style>
        /* Styling untuk halaman profil */
        body {
            font-family: Arial, sans-serif;
            background: url('https://www.pixelstalk.net/wp-content/uploads/2016/11/Earth-From-Space-HD-Backgrounds.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-box {
            background-color: rgba(255, 255, 255, 0.7);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 400px;
        }

        .profile-box h1 {
            color: #333;
        }

        .profile-box p {
            font-size: 18px;
            color: #555;
        }

        .profile-box a {
            text-decoration: none;
            color: white;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
        }

        .profile-box a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="profile-box">
        <h1>Profil Pengguna</h1>
        <p>Selamat datang, <?php echo $_SESSION['username']; ?>!</p>
        <p>Ini adalah halaman profil Anda.</p>
        <a href="logout.php">Logout</a> <!-- Tautan untuk logout -->
    </div>
</body>

</html>