<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "db_toserba");
if (isset($_SESSION['log']) == 'ya') {
} else {
	header('Location: ../index.php');
};

$uid = $_SESSION['id_pembeli'];
$result = mysqli_query($koneksi, "SELECT * FROM cart INNER JOIN pembeli ON cart.id_pembeli = pembeli.id_pembeli INNER JOIN barang ON cart.idBarang = barang.id_barang WHERE cart.id_pembeli = '$uid'");

$totalCoba = mysqli_query($koneksi, "SELECT SUM(total_harga) AS totalBeli FROM cart WHERE id_pembeli = '$uid'");
$totalBeli = mysqli_fetch_array($totalCoba);
$totalBeli['totalBeli'];
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
			<a href="../index.php"> <i class="fas fa-sign-in-alt fa-customize"></i> </a>
		</ul>
	</nav>

	<div class='section'>
		<div class="container-barang">
			<h3>Keranjang</h3>
			<div class="Box">
				<p></p>
			</div>

			<div class="row">
				<div class="kotak-form">
					<table class="tabel">
						<tr>
							<th>Barang</th>
							<th>Jumlah</th>
							<th>Harga Satuan</th>
							<th>Total Harga</th>
						</tr>
						<?php

						if (mysqli_num_rows($result) == 0) {
							echo "Tidak Ada Data Tersedia";
						} else {
							while ($res = mysqli_fetch_assoc($result)) {
						?>
								<tr>
									<td><?php echo $res['nama_barang'] ?></td>
									<td><?php echo number_format($res['jumlah_beli']) ?></td>
									<td><?php echo number_format($res['harga_total_barang']) ?></td>
									<td><?php echo number_format($res['total_harga']) ?></td>
								</tr>
						<?php
							}
						}
						?>
						<tr>
							<td colspan="3">
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
			<?php
			$query = "DELETE FROM cart WHERE id_pembeli = '$uid'";

			mysqli_query($koneksi, $query);
			?>
			<h1 style="text-align: center;">Terima kasih Anda sudah berbelanja di Toko Kami</h1>
</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="script/scriptBarang.js"></script>

</html>