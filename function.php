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

function editmenu($data){
	global $koneksi;

	$id = $data['id'];
	$nama_barang = $data['nama_menu'];
	$jenis = $data['jenis'];
	$harga = $data['harga'];
	$jumlah = $data['jumlah'];

	$query = "UPDATE barang SET
	nama_barang = '$nama_barang',
	jenis_barang = '$jenis',
	harga_barang ='$harga',
	jumlah_barang = '$jumlah'
	WHERE id_barang ='$id'";
	mysqli_query($koneksi, $query);
	return mysqli_affected_rows($koneksi);
}

function hapusmenu($id){
	global $koneksi;

	mysqli_query($koneksi,"DELETE FROM barang WHERE id_barang = '$id'");

	return mysqli_affected_rows($koneksi);
}

function hapusLaporan(){
	global $koneksi;

	mysqli_query($koneksi,"DELETE FROM laporan2");

	return mysqli_affected_rows($koneksi);
}


function hapusakun($id){
	global $koneksi;

	mysqli_query($koneksi,"DELETE FROM pembeli WHERE id_pembeli = '$id'");

	return mysqli_affected_rows($koneksi);
}
?>