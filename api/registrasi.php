<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            background-color: white;
        }

        .error {
            color: #FF0000;
        }

        .form {
            background-color: whitesmoke;
            width: 40%;
            height: 70%;
            padding: 20px;
            /* Add some padding for better layout */
            border-radius: 10px;
            /* Optional: round the corners */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            /* Darker shadow effect */
            margin: auto;
            /* Center the form on the page */
            position: relative;
            /* Required for proper layering */
        }
    </style>
</head>

<body>
    <?php
    // define variables and set to empty values
    $namaErr = $emailErr = $genderErr = $teleponErr = "";
    $nama = $email = $gender = $alamat = $telepon = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["nama"])) {
            $namaErr = "Nama harus diisi";
        } else {
            $nama = test_input($_POST["nama"]);
        }
        if (empty($_POST["email"])) {
            $emailErr = "Email harus diisi";
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Email tidak sesuai format";
            }
        }
        if (empty($_POST["telepon"])) {
            $teleponErr = "No.HP harus diisi";
        } else {
            $telepon = test_input($_POST["telepon"]);
            if (!preg_match("/^[0-9]*$/", $telepon)) {
                $teleponErr = "Di isi dengan angka";
            }
        }
        if (empty($_POST["alamat"])) {
            $alamat = "";
        } else {
            $alamat = test_input($_POST["alamat"]);
        }
        if (empty($_POST["gender"])) {
            $genderErr = "Gender harus dipilih";
        } else {
            $gender = test_input($_POST["gender"]);
        }

        if (empty($namaErr) && empty($emailErr) && empty($teleponErr) && empty($genderErr)) {
            $_SESSION['nama'] = $nama;
            $_SESSION['email'] = $email;
            $_SESSION['telepon'] = $telepon;
            $_SESSION['alamat'] = $alamat;
            $_SESSION['gender'] = $gender;

            // Debugging output
            echo "Debug: Nama: $nama, Email: $email, Telepon: $telepon, Alamat: $alamat, Gender: $gender";

            header("Location: display.php");
            exit();
        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
    <center>
        <h2>Registrasi </h2>
        <p><span class="error"></span></p>

        <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table border="0">
                <center>
                    <tr>
                        <br><br>
                        <td>Nama:</td>
                        <td><input type="text" name="nama">
                            <span class="error">* <?php echo $namaErr; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>E-mail:</td>
                        <td><input type="text" name="email">
                            <span class="error">* <?php echo $emailErr; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>No.HP:</td>
                        <td><input type="text" name="telepon">
                            <span class="error">* <?php echo $teleponErr; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Alamat:</td>
                        <td><textarea name="alamat" rows="5" cols="20"></textarea></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td>
                            <input type="radio" name="gender" value="L">Laki-Laki
                            <input type="radio" name="gender" value="P">Perempuan
                            <span class="error">* <?php echo $genderErr; ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <br><br>
                            <input type="submit" name="submit" value="Submit">
                            <br>

                        </td>
                    </tr>

            </table>

        </form>
    </center>

</body>

</html>