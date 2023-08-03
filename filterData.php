<?php 
include 'koneksi.php';

function select($query)
    {
    //panggil koneksi database
    global $konek;

    $result = mysqli_query($konek, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;

    }

    if (isset($_POST['filter'])) {
        $tgl_awal = strip_tags($_POST['tgl_awal'] . " 00:00:00");
        $tgl_akhir = strip_tags($_POST['tgl_akhir'] . " 23:59:59");

        //queri filter data
        $data_sensor = select("SELECT * FROM tb_sensor WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC");
    }else{

    $data_sensor = select("SELECT * FROM tb_sensor ORDER BY id DESC");
    // akhir tampil data sensor
    }

 ?>

 <!DOCTYPE html>
<html lang="en">

<head>

	<title>Filter data</title>

</head>

<body>
	<div class="form-row ">
            <label for="tgl_awal" class="col-md-2 mr-2">Tanggal Awal</label>
            <label for="tgl_akhir" class="col-md-2 mr-2">Tanggal Akhir</label>
        </div>
        <form method="POST">
        <div class="form-row mb-2 ">
                <input type="date" name="tgl_awal" id="tgl_awal" class="form-control col-md-2 mr-2" >
                <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control col-md-2 mr-2">

        <button type="submit" class="btn btn-success btn-sm mr-2" name="filter" ><i class="fas fa-search"></i> Filter Data</button>
        </div>
    </form>
        <table class="table table-bordered" style="text-align: center; margin-bottom: 0px;">
            <thead>
            <tr class="bg-dark" style=" color: white;">
                <th>No</th>
                <th>Kelembaban Tanah</th>
                <th>Suhu Udara</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        	<?php $no=1; ?>
            <?php foreach ($data_sensor as $sensor): ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $sensor ['nilai_sensor']; ?></td>
                <td><?php echo $sensor ['nilai_sensor']; ?></td>
                <td><?php $timestamp = $sensor ['tanggal'];
                echo date('M d<\s\u\p>S</\s\u\p>, Y | h:i:s',strtotime($timestamp)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
       </table>
</body>

</html>