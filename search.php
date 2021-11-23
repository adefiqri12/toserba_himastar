<?php
include 'function.php';

$cari = $_GET['keyword'];

$result = mysqli_query($koneksi, "SELECT `id_barang`, barang.`jenis_barang`, `nama_barang`, `harga_barang`,`jumlah_barang` FROM `barang` INNER JOIN jenis_barang ON jenis_barang.id_jenis = barang.jenis_barang");

$jumlahDataPerHalaman = 5;
$jumlahData = mysqli_num_rows($result);
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
$query = "SELECT nama_jenis,`id_barang`, barang.`jenis_barang`, `nama_barang`, `harga_barang`,`jumlah_barang` FROM `barang` INNER JOIN jenis_barang ON jenis_barang.id_jenis = barang.jenis_barang
                WHERE nama_barang LIKE '%$cari%' OR
                      harga_barang LIKE '%$cari%' OR
                      nama_jenis LIKE '%$cari%' OR
					  jumlah_barang LIKE '%$cari%'
                      LIMIT $awalData, $jumlahDataPerHalaman";
$menu = mysqli_query($koneksi, $query);
?>

<table class="tabel">
                <thead>
                    <tr>
                        <th>no</th>
                        <th>nama barang</th>
                        <th>jenis barang</th>
                        <th>harga barang</th>
                        <th>jumlah barang</th>
                        <th>opsi</th>
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
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $res['nama_barang']; ?></td>
                                <td><?php echo $res['nama_jenis'] ?></td>
                                <td><?php echo $res['harga_barang'] ?></td>
                                <td><?php echo $res['jumlah_barang'] ?></td>
                                <td class="opsi">
                                    <div class="tombol2">
                                        <a href="editMenu.php?id=<?= $res['id_barang'] ?>"><i class="fa fa-edit"></i> Edit</a>
                                    </div>
                                    <div class="tombol3">
                                        <a href="hapusMenu.php?id=<?= $res['id_barang'] ?>"><i class="fa fa-trash"></i> Hapus</a>
                                    </div>

                                </td>
                            </tr>
                        </tbody>
                <?php
                    }
                } ?>
            </table>