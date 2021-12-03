<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_toserba");

$result = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN jenis_barang ON jenis_barang.id_jenis = barang.jenis_barang");

$jumlahDataPerHalaman = 5;
$jumlahData = mysqli_num_rows($result);
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
$menu = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN jenis_barang ON jenis_barang.id_jenis = barang.jenis_barang LIMIT $awalData, $jumlahDataPerHalaman");
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
        <div class="container-barang">
            <h3>Dahboard</h3>
            <div class="Box">
                <p>Selamat datang</p>
            </div>

            <div class="box-search">
                <div class="kotak-form">
                    <form class="form-input" method="post">
                        <input type="text" name="cari" placeholder="Cari" autocomplete="off" id="cari">
                    </form>
                </div>
            </div>

            <div id="bungkus">
                <table class="tabel">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama barang</th>
                            <th>Jenis</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <?php
                    if (mysqli_num_rows($menu) == 0) {
                        echo "Tidak Ada Data Tersedia";
                    } else {
                        $i = 1;
                        while ($res = mysqli_fetch_assoc($menu)) {
                    ?>
                            <tbody>
                                <tr>
                                    <td class="nomor-tabel"><?php echo $i++; ?></td>
                                    <td><?php echo $res['nama_barang']; ?></td>
                                    <td><?php echo $res['nama_jenis'] ?></td>
                                    <td><?php echo $res['harga_barang'] ?></td>
                                    <td><?php echo $res['jumlah_barang'] ?></td>
                                    <td class="opsi">
                                        <form action="beli.php" method="post">
                                            <div class="tombol-tambahKeranjang">
                                                <i class="fas fa-cart-plus"></i>
                                                <input type="hidden" name="id" value="<?php echo $res['id_barang'] ?>">
                                                <input type="submit" name="addprod" value="Masukkan keranjang" class="buttonTambah">
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                    <?php
                        }
                    } ?>
                </table>
            </div>
        </div>
    </div>
    <div class="pagination">
        <?php if ($halamanAktif > 1) : ?>
            <a href="#">&laquo;</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
            <?php if ($i == $halamanAktif) : ?>
                <a href="?halaman=<?= $i ?>" class="active"><?= $i; ?></a>
            <?php else : ?>
                <a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($halamanAktif < $jumlahHalaman) : ?>
            <a href="?halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>
        <?php endif; ?>

        <?php if ($halamanAktif > $jumlahHalaman) : ?>
            <?php echo "<script>alert('Data tidak ada')</script>";  ?>
        <?php endif; ?>
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