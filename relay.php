<?php 
	// buat koneksi
	include "koneksi.php";

	// tangkap parameter stat yang dikirim dari ajax
	$stat = $_GET['stat'];
	if($stat == "ON")
	{
		// ubah field relay menjadi 1
		mysqli_query($konek, "UPDATE tb_kontrol SET relay=1");
		// Berikan respon 
		echo "ON";

	}
	else
	{
		// ubah field relay menjadi 0
		mysqli_query($konek, "UPDATE tb_kontrol SET relay=0");
		// Berikan respon 
		echo "OFF";
	}
?>