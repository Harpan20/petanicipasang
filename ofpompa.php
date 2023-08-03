<?php 
	// buat koneksi
	include "koneksi.php";

	// tangkap parameter stat yang dikirim dari ajax
	$statusOfPompa = $_GET['statusOfPompa'];
	if($statusOfPompa == "ON")
	{
		// ubah field relay menjadi 1
		mysqli_query($konek, "UPDATE tb_pompa SET nilai=1");
		// Berikan respon 
		echo "ON";

	}
	else
	{
		// ubah field relay menjadi 0
		mysqli_query($konek, "UPDATE tb_pompa SET nilai=0");
		// Berikan respon 
		echo "OFF";
	}
?>