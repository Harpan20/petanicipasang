<?php 
	include "koneksi.php";

	// baca name wifi
	$sql = mysqli_query($konek, "SELECT * FROM tb_wifi");
  	$data = mysqli_fetch_array($sql);
  	$name = $data['name'];

  	echo $name;
 ?>