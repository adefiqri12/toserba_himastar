<?php
session_start();
// include 'function.php';
// $idPembeli = $_SESSION['id_pembeli'];
$koneksi = mysqli_connect("localhost","root","","db_toserba");
if(isset($_POST['addprod'])){
    $idbarang = $_POST['id'];
	if(!isset($_SESSION['log']))
		{	
			header('location:../dashboardBeli.php');
		} else {
				$ui = $_SESSION['id_pembeli'];
				$cek = mysqli_query($koneksi,"SELECT * FROM cart WHERE id_pembeli='$ui' AND idBarang = '$idbarang'");
				$liat = mysqli_num_rows($cek);
				
				//kalo ternyata udeh ada order id nya
				if($liat>0){
                            $f = mysqli_fetch_array($cek);
                            $orid = $f['id_cart'];
							//cek barang serupa
							$cekbrg = mysqli_query($koneksi,"SELECT * FROM cart WHERE idBarang='$idbarang' AND id_cart='$orid'");
							$liatlg = mysqli_num_rows($cekbrg);
							
							//kalo ternyata barangnya ud ada
							if($liatlg>0){
                                $brpbanyak = mysqli_fetch_array($cekbrg);
							    $jmlh = $brpbanyak['jumlah_beli'];
								$i=1;
								$baru = $jmlh + $i;
                                $total = $baru * $brpbanyak['harga_total_barang'];
								$updateaja = mysqli_query($koneksi,"UPDATE cart SET jumlah_beli='$baru', total_harga = '$total' WHERE id_cart='$orid' AND idBarang='$idbarang'");
								
								if($updateaja){
                                    $res  = mysqli_query($koneksi,"SELECT * FROM barang WHERE id_barang = '$idbarang'");
                                    $res2 = mysqli_fetch_assoc($res);
                                    $kurang = 1;
                                    $jumlah = $res2['jumlah_barang'];
                                    $ubahJumlah = ceil($jumlah - $kurang);
                                    $simpanJumlah = mysqli_query($koneksi,"UPDATE barang set jumlah_barang = '$ubahJumlah' WHERE id_barang = '$idbarang'");
									echo " <script>
                                        alert('Barang sudah pernah dimasukkan ke keranjang, jumlah akan ditambahkan')
                                        </script>
                                    <meta http-equiv='refresh' content='1; url= dashboardBeli.php?id=".$idbarang."'/>";
								} else {
									echo " <script> 
                                    alert('Gagal menambahkan ke keranjang')
                                    </script>
                                    <meta http-equiv='refresh' content='1; url= dashboardBeli.php?id=".$idbarang."'/>";
								}
								
							} else {
                                //kalo belom ada order id nya
                                $oi = crypt(rand(22,999),time());
                                $res  = mysqli_query($koneksi,"SELECT * FROM barang WHERE id_barang = '$idbarang'");
                                $res2 = mysqli_fetch_assoc($res);
                                $nama = $res2['nama_barang'];
                                $harga = $res2['harga_barang'];
                                $total = $res2['harga_barang'];
                                $tambahuser = mysqli_query($koneksi,"INSERT INTO cart VALUES ('','$nama','1','$harga','$total','$ui','$idbarang')");
                                if ($tambahuser){
                                    $kurang = 1;
                                    $jumlah = $res2['jumlah_barang'];
                                    $ubahJumlah = ceil($jumlah - $kurang);
                                    $simpanJumlah = mysqli_query($koneksi,"UPDATE barang set jumlah_barang = '$ubahJumlah' WHERE id_barang = '$idbarang'");
                                    echo " <script> 
                                    alert('Berhasil menambahkan ke keranjang')
                                    </script>
                                    <meta http-equiv='refresh' content='1; url= dashboardBeli.php?id=".$idbarang."'/>  ";
                                } else { 
                                    
                                    echo " <script> 
                                    alert('Gagal menambahkan ke keranjang')
                                    </script>
                                    <meta http-equiv='refresh' content='1; url= dashboardBeli.php?id=".$idbarang."'/> ";
                                }
							};
				} else {
						$oi = crypt(rand(22,999),time());      
                        $res  = mysqli_query($koneksi,"SELECT * FROM barang WHERE id_barang = '$idbarang'");
                        $res2 = mysqli_fetch_assoc($res);
                        $nama = $res2['nama_barang'];
                        $harga = $res2['harga_barang'];
                        $total = $res2['harga_barang'];
                        $tambahuser = mysqli_query($koneksi,"INSERT INTO cart values ('','$nama','1','$harga','$total','$ui','$idbarang')");
                        if ($tambahuser){
                            $kurang = 1;
                            $jumlah = $res2['jumlah_barang'];
                            $ubahJumlah = ceil($jumlah - $kurang);
                            $simpanJumlah = mysqli_query($koneksi,"UPDATE barang set jumlah_barang = '$ubahJumlah' WHERE id_barang = '$idbarang'");
                            echo " <script> 
                                alert('Berhasil menambahkan ke keranjang')
                                </script>
                            <meta http-equiv='refresh' content='1; url= dashboardBeli.php?id=".$idbarang."'/>  ";
                        } else { 
                            echo " <script> 
                                alert('Berhasil menambahkan ke keranjang')
                                </script>
                            <meta http-equiv='refresh' content='1; url= dashboardBeli.php?id=".$idbarang."'/> ";
                        }
				}
		}
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://drive.google.com/uc?export=view&id=1DkxJAKaJbRUKbVZbg6W79F9mS_oVcAar" rel="shortcut icon">
    <title>Toserba Himastar</title>
</head>
<body>
    
</body>
</html>