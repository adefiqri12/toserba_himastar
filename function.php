<?php
$koneksi = mysqli_connect("localhost","root","","db_toserba");

function query($query){
	global $koneksi;
	$result = mysqli_query($koneksi, $query);
	$row =[];
	while ($row = mysqli_fetch_assoc($query)) {
		$rows[] = $row;
	}
	return $rows;
}

function upload(){
	$nama = $_FILES['gambar']['name'];
	$x = explode('.', $nama);
	$ukuran	= $_FILES['gambar']['size'];
	$file_tmp = $_FILES['gambar']['tmp_name'];
	$error = $_FILES['gambar']['error'];
	if($error === 4 )
	{
		echo "<script>alert('Gambar Belum di Upload')</script>";
		return false;
	}
	$ekstensi_diperbolehkan	= array('png','jpg','jpeg');
	$ekstensi = strtolower(end($x));

	if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
		if($ukuran < 1044070){			
			move_uploaded_file($file_tmp, 'file/'.$nama);
		}else{
			echo 'UKURAN FILE TERLALU BESAR';
		}
	}else{
		echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
	}
	return $nama;
}

function tambahmenu($data){
	global $koneksi;

	$nama_menu = $data['nama_menu'];
	$kategori = $data['kategori'];
	$harga = ($data['harga']);
	$status = "Tersedia";
	$gambar = upload();
	
	for($i=0;$i<count($nama_menu);$i++){
		if(!$gambar)
		{
			echo "
			<script> 
			alert('Data Gagal Ditambah , ');
			document.location.href = 'tambahMenu.php';
			</script>
			";
			return false;
		}

		$query = "INSERT INTO tb_menu VALUES ('','$nama_menu[$i]','$kategori[$i]','$harga[$i]','$status[$i]','$gambar[$i]')";

		mysqli_query($koneksi, $query);
	}

	return mysqli_affected_rows($koneksi);
}

function editmenu($data){
	global $koneksi;

	$id = $data['id'];
	$nama_barang = $_POST['namaBarang'];
	$jenis = $_POST['jenis'];
	$harga = $_POST['harga'];
	$jumlah = $_POST['jumlah'];

	$query = "UPDATE barang SET
	nama_barang = '$nama_barang', 
	harga_barang ='$harga',
	jenis_barang = '$jenis',
	jumlah_barang = '$jumlah'
	WHERE id ='$id'";
	mysqli_query($koneksi, $query);
	return mysqli_affected_rows($koneksi);
}

function hapusmenu($id){
	global $koneksi;

	mysqli_query($koneksi,"DELETE FROM barang WHERE id_barang = '$id'");

	return mysqli_affected_rows($koneksi);
}

function hapusakun($id){
	global $koneksi;

	mysqli_query($koneksi,"DELETE FROM pembeli WHERE id_pembeli = '$id'");

	return mysqli_affected_rows($koneksi);
}
