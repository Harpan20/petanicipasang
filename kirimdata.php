<?php 
	//koneksi database
	include "koneksi.php";

	//tangkap parameter yang dikirim oleh nodemcu
	$nilaisensor = $_GET['nilaisensor'];
	$nilaisuhu = $_GET['nilaisuhu'];
	$nilaikelembabanudara = $_GET['nilaikelembabanudara'];

	if($nilaisuhu  == "2147483647" ) $nilaisuhu = 0;
	if($nilaikelembabanudara == "2147483647" ) $nilaikelembabanudara = 0;

	// echo $_GET['nilaisensor'];
	// echo $_GET['nilaisuhu'];
	// echo $_GET['nilaikelembabanudara'];

	// simpan ke tb_sensor
	// atur ID selalu dimulai dari 1
	mysqli_query($konek, "ALTER TABLE tb_sensor AUTO_INCREMENT=1");
	// simpan nilai sensor ke tabel tb_sensor
	$simpan = mysqli_query($konek, "INSERT INTO tb_sensor (nilai_sensor, suhu, kelembabanUdara) VALUES ('$nilaisensor', '$nilaisuhu', '$nilaikelembabanudara')");


	// berikan sensor ke node mcu
	if ($simpan)
		echo "Berhasil Tersimpan";
	else
		echo "Gagal Tersimpan";

 ?>