<?php 
	include 'koneksi.php';

	$sql_ID = mysqli_query($konek, "SELECT MAX(ID) FROM tb_sensor") ;
	//tanggal datanya
	$data_ID = mysqli_fetch_array($sql_ID) ;
	// ambil ID akhir
	$ID_akhir = $data_ID['MAX(ID)']; // ID Terakhir
	$ID_awal = $ID_akhir - 3 ; //

	// baca informasi tanggal untuk 5 data terakhir - sumbu x
	$tanggal=mysqli_query($konek, "SELECT tanggal FROM tb_sensor WHERE ID>='$ID_awal' and ID<='$ID_akhir' ORDER BY ID ASC") ;

	// $data_tanggal = mysqli_fetch_array($tanggal);
	$timestamp = $data_tanggal['tanggal'];


	echo date('h/i/s',strtotime($timestamp));
	
  
  	while($data_tanggal=mysqli_fetch_array($tanggal))
            {
              echo '"'.date('h/i/s',strtotime($timestamp)),'",' ;
            }

?>
 