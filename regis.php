<?php

$koneksi = mysqli_connect("localhost", "root", "", "db_toserba");

if (isset($_POST['submit'])) {
    $nama        = $_POST['nama'];
    $noTelp      = $_POST['noTelp'];
    $alamat       = $_POST['alamat'];
    $username    = $_POST['username'];
    $password    = md5($_POST['password']);
    $confirmPass = md5($_POST['confirmPass']);
    $syaratPass = $_POST['password'];
    $karakter   = preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/", $syaratPass);

    if (strlen($syaratPass) >= 6 && $karakter) {
        if ($password == $confirmPass) {
            $sqlQuery = "SELECT * FROM pembeli WHERE username='$username'";
            $result = mysqli_query($koneksi, $sqlQuery);
            if (mysqli_num_rows($result) == 0) {
                $sql = "INSERT INTO pembeli (nama_pembeli, no_hp, alamat, username, password) VALUES ('$nama', '$noTelp', '$alamat', '$username', '$password')";
                $result = mysqli_query($koneksi, $sql);
                echo "<script>alert('Registrasi berhasil!')</script>";
            } else {
                echo "<script>alert('Username yang digunakan Sudah Terdaftar. Silahkan gunakan Username yang lain')</script>";
            }
        } else {
            echo "<script>alert('Password dan Confirm Password Tidak Sama')</script>";
        }
    } else {
        echo "<script>alert('Syarat Password Tidak Terpenuhi.')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/hias.css">
    <link href="https://drive.google.com/uc?export=view&id=1DkxJAKaJbRUKbVZbg6W79F9mS_oVcAar" rel="shortcut icon">
    <title>Registrasi | Himastar</title>
</head>

<body>
    <div class="nav-awal">
        <div class="logo">
            <h4>Himastar</h4>
        </div>
    </div>

    <div class='container'>
        <div class="box-login">
            <h2>Sign up</h2>

            <form action="" method="POST">
                <input class="input-regis" type="text" name="nama" placeholder="Nama Lengkap">
                <input class="input-regis" type="text" name="noTelp" placeholder="Nomor telepon">
                <input class="input-regis" type="text" name="alamat" placeholder="Alamat">
                <input class="input-regis" type="text" name="username" placeholder="Username">
                <p>*Password Minimal 6 karakter (Terdiri Angka dan Huruf)</p>
                <input class="input-regis" type="password" name="password" placeholder="Password">
                <input class="input-regis" type="password" name="confirmPass" placeholder="Konfirmasi Password">
                <input class="btn-submit" type="submit" name="submit" value="Daftar">
            </form>
            <div class="text-regis">
                <p>Sudah punya akun?</p><span><a href="./index.php">Masuk</a></span>
            </div>
        </div>
    </div>
    <footer>
        <div class="container-footer">
            <p>Copyright &copy; 2021</p>
        </div>
    </footer>
</body>

</html>