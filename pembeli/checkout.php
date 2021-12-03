<?php 
    session_start();
    $koneksi = mysqli_connect("localhost","root","","db_toserba");
    if(isset($_SESSION['log']) == 'ya'){
            
    } else {
        header('Location: ../index.php');
    };

    $uid = $_SESSION['id_pembeli'];
    $username = $_SESSION['username'];
    $namaPembeli = $_SESSION['nama_pembeli'];
    $caricart = mysqli_query($koneksi,"SELECT * FROM cart INNER JOIN barang ON cart.idBarang = barang.id_barang WHERE cart.id_pembeli = '$uid'");
    // $fetc = mysqli_fetch_array($caricart);

    if (mysqli_num_rows($caricart)== 0) {
        echo "Tidak Ada Data Tersedia";
    }else{
        while ($fetc = mysqli_fetch_assoc($caricart)) {
            $namaBarang = $fetc['nama_barang'];
            $jumlahBeli = $fetc['jumlah_beli'];
            $hargaBarang = $fetc['harga_barang'];
            $totalHarga = $fetc['total_harga'];

            $query = "INSERT INTO laporan2 VALUES ('','$namaPembeli','$username','$namaBarang','$jumlahBeli','$hargaBarang','$totalHarga',0)";
            mysqli_query($koneksi, $query);
        }
        if (mysqli_affected_rows($koneksi)>0) {
            echo "
             <script> 
             alert('Checkout Berhasil, Struk Akan Tampil');
             document.location.href = 'tampilCO.php';
             </script>
             ";
         }else{
            echo "
            <script> 
            alert('Checkout Gagal, ');
            document.location.href = 'cart.php';
            </script>
            ";
         }
    }
?>