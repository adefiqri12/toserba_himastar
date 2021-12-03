<?php 
    include 'function.php';

    $cari = $_GET['keyword'];
	
	$result = mysqli_query($koneksi,"SELECT * FROM laporan2");
	
    $query = "SELECT * FROM laporan2
                WHERE namaPembeli LIKE '%$cari%' OR
					  username LIKE '%$cari%' OR
					  namaBarang LIKE '%$cari%' OR
					  jumlahBeli LIKE '%$cari%' OR
					  hargaBarang LIKE '%$cari%' OR
                      totalHarga LIKE '%$cari%'";
    $menu = mysqli_query($koneksi,$query);
?>

<div class="row">
		<table class="table-data">
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
			if (mysqli_num_rows($menu)== 0) {
				echo "Tidak Ada Data Tersedia";
			}else{
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
					$totalCoba = mysqli_query($koneksi,"SELECT SUM(totalHarga) AS totalLaporan FROM laporan2");
					$totalBeli = mysqli_fetch_array($totalCoba); ?>
					<span style="font-weight: bold;">Rp. <?php echo number_format($totalBeli['totalLaporan']);?></span>
				</td>
			</tr>
		</table>
	</div>