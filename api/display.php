<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data yang Anda Isi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            /* Light background color */
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            /* White background for the profile card */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 600px;
            margin: auto;
            /* Center the card */
        }

        h2 {
            color: #333;
            /* Darker text color */
            text-align: center;
            /* Centered title */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /* Merge borders */
            margin-top: 20px;
            /* Space above the table */
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            /* Align text to the left */
            border-bottom: 1px solid #eee;
            /* Separator line */
        }

        th {
            background-color: #f2f2f2;
            /* Light grey background for header */
            color: #333;
            /* Darker text color */
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
            /* Link color */
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
            /* Underline on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>PROFIL ANDA:</h2>
        <?php if (isset($_SESSION['nama'])): ?>
            <table>
                <tr>
                    <th>Field</th>
                    <th>Data</th>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td><?php echo $_SESSION['nama']; ?></td>
                </tr>
                <tr>
                    <td>E-mail</td>
                    <td><?php echo $_SESSION['email']; ?></td>
                </tr>
                <tr>
                    <td>No.HP</td>
                    <td><?php echo $_SESSION['telepon']; ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><?php echo $_SESSION['alamat']; ?></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td><?php echo $_SESSION['gender']; ?></td>
                </tr>
            </table>

            <?php
            // Clear session data (optional)
            session_unset();
            session_destroy();
            ?>
        <?php else: ?>
            <div class="profile-item">Tidak ada data yang ditemukan.</div>
        <?php endif; ?>
        <a href="index.php">Kembali ke home</a>
    </div>
</body>

</html>