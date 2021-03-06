<?php
include 'function.php';

$menu = mysqli_query($koneksi,"SELECT * FROM laporan2");
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
            <a href="index.php"> <i class="fas fa-sign-in-alt fa-customize"></i> </a>
        </ul>
    </nav>

    <div class='section'>
        <div class="container-barang">
            <h3>Laporan</h3>
            <div class="Box">
                <p></p>
            </div>

            <div id="bungkus">
                <div class="">
                    <table class="tabel">
                        <tr>
                            <!-- <th>No</th> -->
                            <th>Nama Pembeli</th>
                            <th>Username</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Harga Barang</th>
                            <th>Total Harga</th>
                        </tr>
                        <?php
                        if (mysqli_num_rows($menu) == 0) {
                            echo "Tidak Ada Data Tersedia";
                        } else {
                            while ($res = mysqli_fetch_assoc($menu)) {
                                // $simpan = $res['namaPembeli'];
                                // $tampilNama = mysqli_query($koneksi,"SELECT * FROM laporan2 WHERE namaPembeli = '$simpan'");
                                // $simpanBaris = mysqli_num_rows($tampilNama);
                        ?>
                                <tr>
                                    <td><?php echo $res['namaPembeli']; ?></td>
                                    <td><?php echo $res['username'] ?></td>
                                    <td><?php echo $res['namaBarang'] ?></td>
                                    <td><?php echo number_format($res['jumlahBeli']) ?></td>
                                    <td><?php echo number_format($res['hargaBarang']) ?></td>
                                    <td><?php echo number_format($res['totalHarga']) ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="5">
                                <span style="font-weight: bold;">TOTAL</span>
                            </td>
                            <td>
                                <?php
                                $totalCoba = mysqli_query($koneksi, "SELECT SUM(totalHarga) AS totalLaporan FROM laporan2");
                                $totalBeli = mysqli_fetch_array($totalCoba); ?>
                                <span style="font-weight: bold;">Rp. <?php echo number_format($totalBeli['totalLaporan']); ?></span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="tmbl" style="width: 5%;">
                <div class="tombol3">
                    <a href="hapusLaporan.php"><i class="fa fa-trash"></i> Hapus Semua</a>
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