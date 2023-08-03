<?php 
	include "koneksi.php";

	$sql = mysqli_query($konek, "select * from tb_sensor order by id desc"); // data terakhir berada di atas

	$data = mysqli_fetch_array($sql);
	$suhu = $data ['suhu'];
	$kelembabanUdara = $data ['kelembabanUdara'];

	// uji apabila nilai suhu belum ada maka anggap = 0
	if($suhu  == "2147483647" ) $suhu = 0;
	if($kelembabanUdara == "2147483647" ) $kelembabanUdara = 0;

	echo $suhu, "°C", "   /   ", $kelembabanUdara, "%";


 ?>