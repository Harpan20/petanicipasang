<?php 
	// include koneksi
	include "koneksi.php";

	$id = $_GET['id'];

	// hapus data
	mysqli_query($konek, "delete from tb_jam where id='$id'");

	//aksi tombol kembali ke index
	echo "<script> location.replace('index.php');</script>";

 ?>