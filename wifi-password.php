<?php 
	include "koneksi.php";

	// baca name wifi
	$sql = mysqli_query($konek, "SELECT * FROM tb_wifi");
  	$data = mysqli_fetch_array($sql);
  	$password = $data['password'];

  	echo $password;
 ?>