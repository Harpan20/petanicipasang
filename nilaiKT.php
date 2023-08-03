<?php 
	//menampilkan data terakhir variabel kelembaban di tb_sensor

	include "koneksi.php";

	$sql = mysqli_query($konek, "SELECT * FROM tb_bataslembabtanah");
  	$data = mysqli_fetch_array($sql);
  	$kelembaban = $data['kelembaban'];

  	$sqloFPompa = mysqli_query($konek, "SELECT * FROM tb_pompa");
    $dataOfPompa = mysqli_fetch_array($sqloFPompa);
    $ofPompa=$dataOfPompa ['nilai'];

    $sqltbsensor = mysqli_query($konek, "select * from tb_sensor order by id desc"); // data terakhir berada di atas
	$datatbsensor = mysqli_fetch_array($sqltbsensor);
	$nilaisensor = $datatbsensor ['nilai_sensor'];

	// // baca ID tertinggi
	// $sql_ID = mysqli_query($konek, "SELECT MAX(ID) FROM tb_sensor") ;
	// //tanggal datanya
	// $data_ID = mysqli_fetch_array($sql_ID) ;
	// // ambil ID akhir
	// $ID_akhir = $data_ID['MAX(ID)']; // ID Terakhir

 	// $bacasensorakhir=mysqli_query($konek, "SELECT nilai_sensor FROM tb_sensor WHERE ID='$ID_akhir' ORDER BY ID ASC") ;

	// $kampret = mysqli_fetch_array($bacasensorakhir) ;
	// $nilaisensor = $kampret['nilai_sensor'];

	echo $nilaisensor, "%";

	// echo $ofPompa;


		if (($ofPompa == 1) && ($nilaisensor > $kelembaban))
		{
			mysqli_query($konek, "UPDATE tb_kontrol set relay=0");
		}

              




	// // update status semua jam menjadi nol
	// mysqli_query($konek, "UPDATE tb_jam set status=0");

 ?>