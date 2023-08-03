<?php  
	include "koneksi.php";

	$sql = mysqli_query($konek, "SELECT * FROM tb_kontrol");
	$data = mysqli_fetch_array($sql);
	$relay = $data['relay'];
	// response balik ke nodemcu
	echo $relay; // 1 / 0

?>