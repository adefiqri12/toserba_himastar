<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_toserba");
session_start();
$uid = $_SESSION['id_pembeli'];
$caricart = mysqli_query($koneksi, "SELECT * FROM cart WHERE id_pembeli='$uid'");
$fetc = mysqli_fetch_array($caricart);

if (isset($_POST["update"])) {
    $kode = $_POST['idproduknya'];
    $jumlah = $_POST['jumlah'];
    $q2 = mysqli_query($koneksi, "SELECT * FROM cart WHERE idBarang='$kode' AND id_pembeli = '$uid'");
    $res3 = mysqli_fetch_assoc($q2);
    $jumlahBefore = $res3['jumlah_beli'];

    $res  = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = '$kode'");
    $res2 = mysqli_fetch_assoc($res);

    $jumlah2 = $res2['jumlah_barang'];
    $lebihJumlah = ceil($jumlah2 + $jumlahBefore);
    if ($lebihJumlah < $jumlah) {

        echo " <script> 
            alert('Gagal update cart. Melebihi Stok')
            </script>
        <meta http-equiv='refresh' content='1; url= cart.php'/>";
    } else {
        if ($jumlah == 0) {
            $jumlah2 = $res2['jumlah_barang'];
            $ubahJumlah = ceil($jumlah2 + $jumlahBefore);
            $simpanJumlah = mysqli_query($koneksi, "UPDATE barang set jumlah_barang = '$ubahJumlah' WHERE id_barang = '$kode'");

            $hapusCart = mysqli_query($koneksi, "DELETE FROM cart WHERE idBarang = '$kode' AND id_pembeli = '$uid'");
            echo "<script> 
            alert('Berhasil Update Barang. Barang Akan Terhapus')
            </script>
            <meta http-equiv='refresh' content='1; url= cart.php'/>";
        } else {
            $harga = $res2['harga_barang'];
            $total = $jumlah * $harga;

            $q1 = mysqli_query($koneksi, "UPDATE cart set jumlah_beli='$jumlah', total_harga = '$total' WHERE idBarang='$kode' AND id_pembeli = '$uid'");

            if ($q1) {
                $jumlah2 = $res2['jumlah_barang'];
                $ubahJumlah = ceil(($jumlah2 + $jumlahBefore) - $jumlah);
                $simpanJumlah = mysqli_query($koneksi, "UPDATE barang set jumlah_barang = '$ubahJumlah' WHERE id_barang = '$kode'");
                echo "<script> 
                alert('Berhasil Update Barang')
                </script>
                <meta http-equiv='refresh' content='1; url= cart.php'/>";
            } else {
                echo " <script> 
                alert('Gagal update cart')
                </script>
                <meta http-equiv='refresh' content='1; url= cart.php'/>";
            }
        }
    }
} else if (isset($_POST["hapus"])) {
    $kode = $_POST['idproduknya'];

    $q2 = mysqli_query($koneksi, "SELECT * FROM cart WHERE idBarang='$kode' AND id_pembeli = '$uid'");
    $res3 = mysqli_fetch_assoc($q2);
    $jumlahBefore = $res3['jumlah_beli'];

    $q2 = mysqli_query($koneksi, "DELETE FROM cart WHERE idBarang='$kode' AND id_pembeli = '$uid'");
    if ($q2) {
        $res  = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang = '$kode'");
        $res2 = mysqli_fetch_assoc($res);
        $jumlah2 = $res2['jumlah_barang'];
        $ubahJumlah = ceil($jumlah2 + $jumlahBefore);
        $simpanJumlah = mysqli_query($koneksi, "UPDATE barang set jumlah_barang = '$ubahJumlah' WHERE id_barang = '$kode'");
        echo " <script> 
            // alert('Berhasil Hapus Barang')
            </script>";
    } else {
        echo " <script> 
            alert('Gagal Hapus Barang')
            </script>";
    }
}
$menu = mysqli_query($koneksi, "SELECT * FROM cart INNER JOIN pembeli ON cart.id_pembeli = pembeli.id_pembeli INNER JOIN barang ON cart.idBarang = barang.id_barang WHERE cart.id_pembeli = '$uid'");
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
    <title>Toserba Himastar</title>
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
            <h3>Keranjang</h3>
            <div id="bungkus">

                <div class="row">
                    <table class="tabel">
                        <tr>
                            <!-- <th>No</th> -->
                            <th>ID Pembelian</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                            <th>Opsi</th>
                        </tr>
                        <?php

                        if (mysqli_num_rows($menu) == 0) {
                            echo "Tidak Ada Data Tersedia";
                        } else {
                            while ($res = mysqli_fetch_assoc($menu)) {
                        ?>
                                <tr>
                                    <form method="POST">
                                        <td><?php echo $res['id_cart']; ?></td>
                                        <td><?php echo $res['nama_barang'] ?></td>
                                        <td>
                                            <div class="quantity">
                                                <div class="quantity-select">
                                                    <input type="number" name="jumlah" class="form-control" height="100px" value="<?php echo $res['jumlah_beli'] ?>" \>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo number_format($res['harga_total_barang']) ?></td>
                                        <td><?php echo number_format($res['total_harga']) ?></td>
                                        <td class="opsi">
                                            <!-- <a href="hapusAkun.php?id=<?= $res['id_cart'] ?>"><i class="fa fa-trash"></i> Hapus</a> -->
                                            <input type="submit" name="update" class="form-control1" value="Update" \>
                                            <input type="hidden" name="idproduknya" value="<?php echo $res['id_barang'] ?>" \>
                                            <input type="submit" name="hapus" class="form-control2" value="Hapus" \>
                                    </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="5">
                                <span style="font-weight: bold;">TOTAL PEMBELIAN</span>
                            </td>
                            <td>
                                <?php
                                $totalCoba = mysqli_query($koneksi, "SELECT SUM(total_harga) AS totalBeli FROM cart WHERE id_pembeli = '$uid'");
                                $totalBeli = mysqli_fetch_array($totalCoba); ?>
                                <span style="font-weight: bold;">Rp. <?php echo number_format($totalBeli['totalBeli']); ?></span>

                            </td>
                        </tr>
                    </table>
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