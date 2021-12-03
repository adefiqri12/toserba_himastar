<?php
include 'function.php';

$id = $_GET['id'];

$menu = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN jenis_barang ON jenis_barang.id_jenis = barang.jenis_barang WHERE id_barang='$id'");
$men = mysqli_fetch_assoc($menu);

if (isset($_POST['edit'])) {
    if (editmenu($_POST) > 0) {
        echo "
		<script>
		alert('Data Berhasil Diubah');
		document.location.href ='index.php';
		</script>
		";
    } else {
        echo "
		<script>
		alert('Data Gagal Diubah');
		document.location.href ='editMenu.php?id=" . $id . "';
		</script>
		";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dashboard admin | Himastar</title>
</head>

<body>
    <nav>
        <div class="logo">
            <h4>Himastar</h4>
        </div>
        <ul>
            <li><a href="dashboardAdmin.php">Data produk</a></li>
            <li><a href="akunPembeli.php">Manajemen akun</a></li>
            <li><a href="akunAdmin.php">Tambah admin</a></li>
            <li><a href="laporan.php">Laporan</a></li>
            <a href="index.php  "> <i class="fas fa-sign-in-alt fa-customize"></i> </a>
        </ul>
    </nav>

    <div class='section'>
        <div class="container-barang">
            <h3>Edit produk</h3>
            <div class="box-tengah">
                <div class="row">
                    <div class="kotak-form">
                        <form class="form-input" method="post">

                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <label><span>Nama Barang</span></label>
                            <input type="text" name="nama_menu" class="input-field" value="<?php echo $men['nama_barang'] ?>">

                            <label><span>Jenis Barang</span></label>
                            <select class="input-field" name="jenis" id="">
                                <option value="<?= $men['jenis_barang'] ?>"><?= $men['nama_jenis'] ?></option>
                                <?php
                                $data = mysqli_query($koneksi, "SELECT * FROM jenis_barang");
                                while ($d = mysqli_fetch_array($data)) { ?>

                                    <option value="<?= $d['id_jenis'] ?>"><?= $d['nama_jenis'] ?></option>
                                <?php } ?>
                            </select>

                            <label><span>Harga</span></label>
                            <input type="number" name="harga" class="input-field" value="<?php echo $men['harga_barang'] ?>">

                            <label><span>Stok Barang</span></label>
                            <input type="number" name="jumlah" class="input-field" value="<?php echo $men['jumlah_barang'] ?>">

                            <button name="edit" type="submit" class="submit"><i class="fa fa-check-circle"></i> SUBMIT</button>
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