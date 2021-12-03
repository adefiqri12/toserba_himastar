<?php
session_start();
$koneksi = mysqli_connect("localhost","root","","db_toserba");
if(isset($_SESSION['log']) == 'ya'){
            
} else {
    header('Location: ../index.php');
};
$id = $_SESSION['id_pembeli'];

$menu = mysqli_query($koneksi, "SELECT * FROM pembeli WHERE id_pembeli='$id'");
$men = mysqli_fetch_assoc($menu);
$_SESSION['username'] = $men['username'];
$_SESSION['password'] = $men['password'];

$usern = $_SESSION['username'];
$pass = $_SESSION['password'];

if (isset($_POST['editAkun'])) {
	$nama = $_POST['nama'];
	$notelp = $_POST['notelp'];
	$alamat = $_POST['alamat'];
    $username = $_POST['username'];
    $password    = $_POST['pass'];
    $confirmPass = $_POST['confirmPassword'];
    // var_dump($_POST['password']);
    // die();
    if(md5($_POST["passwordLama"]) != $pass){
        echo "<script>alert('Password Lama Invalid')</script>";
    }else{
        if($username == $usern){
            if($password == ''){
                $query = "UPDATE pembeli SET
                nama_pembeli = '$nama', 
                no_hp ='$notelp',
                alamat = '$alamat',
                username = '$username'
                WHERE id_pembeli ='$id'";
                mysqli_query($koneksi, $query);
                
                if (mysqli_affected_rows($koneksi)>0) {
                    echo "
                    <script> 
                    alert('Akun Berhasil diubah');
                    document.location.href = 'infoAkun.php';
                    </script>
                    ";
                }else{
                    echo "<script>alert('Username yang digunakan Sudah Terdaftar. Silahkan gunakan Username yang lain')</script>";
                }
            }
            else{
                $password    = md5($_POST['pass']);
                $confirmPass = md5($_POST['confirmPassword']);
                $syaratPass = $_POST['pass'];
                $karakter   = preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/", $syaratPass);
    
                if ( strlen($syaratPass) >= 6 && $karakter)
                {
                    if ($password == $confirmPass) {
                        $sql = "UPDATE pembeli SET
                                nama_pembeli = '$nama', 
                                no_hp ='$notelp',
                                alamat = '$alamat',
                                username = '$username',
                                password = '$password'
                                WHERE id_pembeli ='$id'";
                        $result = mysqli_query($koneksi, $sql);
                        echo "
                        <script> 
                        alert('Akun Berhasil diubah');
                        document.location.href = 'infoAkun.php';
                        </script>
                        ";
                    }
                    else {
                        echo "<script>alert('Password dan Confirm Password Tidak Sama')</script>";
                    }
                }
                else{
                    echo "<script>alert('Syarat Password Tidak Terpenuhi.')</script>";
                }
            }
        }else{
            $sqlQuery = "SELECT * FROM pembeli WHERE username='$username'";
            $result = mysqli_query($koneksi, $sqlQuery);
            if($password == ''){
                if (mysqli_num_rows($result) == 0) {
                    $query = "UPDATE pembeli SET
                        nama_pembeli = '$nama', 
                        no_hp ='$notelp',
                        alamat = '$alamat',
                        username = '$username'
                        WHERE id_pembeli ='$id'";
                        mysqli_query($koneksi, $query);
                        echo "
                        <script>
                        alert('Akun Berhasil diubah')
                        document.location.href = 'infoAkun.php';
                        </script>";
                } else {
                    echo "<script>alert('Username yang digunakan Sudah Terdaftar. Silahkan gunakan Username yang lain')</script>";
                }
            }
            else{
                $password    = md5($_POST['pass']);
                $confirmPass = md5($_POST['confirmPassword']);
                $syaratPass = $_POST['pass'];
                $karakter   = preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/", $syaratPass);
    
                if ( strlen($syaratPass) >= 6 && $karakter)
                {
                    if ($password == $confirmPass) {
                        if (mysqli_num_rows($result) == 0) {
                            $sql = "UPDATE pembeli SET
                                    nama_pembeli = '$nama', 
                                    no_hp ='$notelp',
                                    alamat = '$alamat',
                                    username = '$username',
                                    password = '$password'
                                    WHERE id_pembeli ='$id'";
                            $result = mysqli_query($koneksi, $sql);
                            echo "
                            <script> 
                            alert('Akun Berhasil diubah');
                            document.location.href = 'infoAkun.php';
                            </script>
                            ";
                        } else {
                            echo "<script>alert('Username yang digunakan Sudah Terdaftar. Silahkan gunakan Username yang lain')</script>";
                        }
                    }
                    else {
                        echo "<script>alert('Password dan Confirm Password Tidak Sama')</script>";
                    }
                }
                else{
                    echo "<script>alert('Syarat Password Tidak Terpenuhi.')</script>";
                }
            }
        }
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://drive.google.com/uc?export=view&id=1DkxJAKaJbRUKbVZbg6W79F9mS_oVcAar" rel="shortcut icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Toserba Himastar </title>
</head>

<body>
    <nav>
        <div class="logo">
            <h4>Himastar</h4>
        </div>
        <ul>
            <li><a href="dashboardBeli.php">Barang</a></li>
            <li><a href="cart.php">Keranjang</a></li>
            <li><a href="infoAkun.php">Info Akun</a></li>
            <a href="index.php"> <i class="fas fa-sign-in-alt fa-customize"></i> </a>
        </ul>
    </nav>

    <div class='section'>
        <div class="container-profile">
            <h2>Profile</h2>

            <div class="box-profile">
                <div class="photo-profile">
                    <div class="photo">
                        <img src="https://drive.google.com/uc?export=view&id=1DkxJAKaJbRUKbVZbg6W79F9mS_oVcAar" alt="shortcut icon">
                        <label for="input-photo" class="label-input-photo">Ganti foto profile</label>
                        <input type="file" name="photo" id="input-photo" accept="image/*"/>

                    </div>
                </div>

                <div class="form-input">
                    <form class="form-input" method="post">
                        <label><span>Nama</span></label>
                        <input type="text" name="nama" placeholder="Nama" class="input-field" value="<?php echo $men['nama_pembeli'] ?>">

                        <label><span>No Telp</span></label>
                        <input type="text" name="notelp" placeholder="No Telp" class="input-field" value="<?php echo $men['no_hp'] ?>">

                        <label><span>Alamat</span></label>
                        <input type="text" name="alamat" placeholder="Alamat" class="input-field" value="<?php echo $men['alamat'] ?>">

                        <label><span>Username</span></label>
                        <input type="text" name="username" class="input-field" value="<?php echo $men['username'] ?>">

                        <label><span>Password Lama</span></label>
                        <div class="input-group">
                            <input type="password" name="passwordLama" placeholder="Password Lama" class="input-field" required>
                        </div>

                        <label><span>Password Baru</span></label>
                        <div class="input-group">
                            <input type="password" placeholder="Password Baru" name="pass" class="input-field">
                            <p>*Password Minimal 6 karakter (Terdiri Angka dan Huruf)</p>
                        </div>

                        <label><span>Konfirmasi Password</span></label>
                        <div class="input-group">
                            <input type="password" placeholder="Konfirmasi Password" name="confirmPassword" class="input-field">
                        </div>

                        <button name="editAkun" type="submit" class="submit"><i class="fa fa-check-circle fa-customize"></i> Ubah Akun</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <footer>
        <div class="container-footer">
            <p>Copyright &copy;Himastar 2021</p>
        </div>
    </footer>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="script/scriptBarang.js"></script>
</body>

</html>