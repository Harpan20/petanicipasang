<?php 
	// tampilkan jam otomatis
	date_default_timezone_set("Asia/Jakarta");
	$jam = date ('H:i:s');
	echo $jam;

	include "koneksi.php";
	$sql = mysqli_query($konek, "select * from tb_jam order by id asc");
	while($data = mysqli_fetch_array($sql))
	{
		$id = $data['id'];
		$jamdb = $data['jam'];
		//bandingkan dengan jam sekarang
		if($jam == $jamdb)
		{
			// update status jam tersebut dengan nilai 1
			// mysqli_query($konek, "UPDATE tb_kontrol set relay=1 where id='$id'");
			mysqli_query($konek, "UPDATE tb_kontrol set relay=1");
		}
	}

 ?>