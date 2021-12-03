<?php 
require 'function.php';

if (hapusLaporan()>0) {
	echo"<script> alert('data berhasil dihapus');
        document.location.href ='laporan.php';
        </script>";

}else {
	echo "<script> alert('data gagal dihapus');
        document.location.href ='laporan.php';
        </script>";
}
 ?> 