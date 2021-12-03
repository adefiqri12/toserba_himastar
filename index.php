<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "db_toserba");
 
if (isset($_POST['submit'])) {
	$username= mysqli_real_escape_string($koneksi,$_POST['username']);
    $pass = mysqli_real_escape_string($koneksi,$_POST['password']);
	$password = md5($pass);

	$queryAdmin = mysqli_query($koneksi,"SELECT * FROM admin WHERE username ='$username' AND password ='$password'");
	$queryPembeli = mysqli_query($koneksi,"SELECT * FROM pembeli WHERE username ='$username' AND password ='$password'");

	$cekAdmin = mysqli_num_rows($queryAdmin);
	$cekPembeli = mysqli_num_rows($queryPembeli);
	if ($cekAdmin == 0 && $cekPembeli == 0) {
		echo "<script>alert('Username atau Password Anda salah. Silahkan coba lagi!')</script>";
	}else if ($cekAdmin > 0){
		$row = mysqli_fetch_assoc($queryAdmin);
		$_SESSION['username'] = $row['username'];
		$_SESSION['nama_lengkap'] = $row['nama_lengkap'];
		$_SESSION['log'] ='ya';
		header('Location: dashboardAdmin.php');
	}
	else if ($cekPembeli > 0){
		$row = mysqli_fetch_assoc($queryPembeli);
		$_SESSION['username'] = $row['username'];
		$_SESSION['nama_pembeli'] = $row['nama_pembeli'];
		$_SESSION['id_pembeli'] = $row['id_pembeli'];
		$_SESSION['password'] = $row['password'];
		$_SESSION['log'] ='ya';
		header('Location: pembeli/dashboardBeli.php');
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
    <title>Login | Himastar</title>
</head>

<body>
    <div class="nav-awal">
        <div class="logo">
            <h4>Himastar</h4>
        </div>
    </div>

    <div class='container'>
        <div class="box-login">
            <h2>Log in</h2>

            <form action="" method="POST">
                <input class="input-login" type="text" name="username" placeholder="Username">
                <input class="input-login" type="password" name="password" placeholder="Password">
                <input class="btn-submit" type="submit" name="submit" value="Login">
            </form>
            <div class="text-regis">
                <p>Belum punya akun?</p><span><a href="./regis.php">Daftar</a></span>
            </div>
        </div>
    </div>

    <footer>
        <div class="container-footer">
            <p>Copyright &copy;Himastar 2021</p>
        </div>
    </footer>
</body>

</html>