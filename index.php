<!-- baca status trakhir relay serco -->
<?php  
    // include koneksi
    include "koneksi.php";
    session_start();

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

    // query tampil data dengan pagination
        $jumlahDataPerhalaman = 500;
        $jumlahData = count(select("SELECT * FROM tb_sensor"));
        $jumlahHalaman = ceil ($jumlahData / $jumlahDataPerhalaman);
        $halamanAktif = (isset($_GET['halaman']) ? $_GET['halaman'] : 1);

        $awalData   = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

        $jumlahLink = 2;

        if ($halamanAktif > $jumlahLink) {
            $startNumber = $halamanAktif - $jumlahLink;
        }else {
            $startNumber = 1;
        }

        if($halamanAktif < ($jumlahHalaman - $jumlahLink)){
            $endNumber = $halamanAktif + $jumlahLink;
        }else{
            $endNumber = $jumlahHalaman;
        }


    if (isset($_POST['filter'])) {


        $tgl_awal = strip_tags($_POST['tgl_awal'] . " 00:00:00");
        $tgl_akhir = strip_tags($_POST['tgl_akhir'] . " 23:59:59");

        $jumlahData = count(select("SELECT * FROM tb_sensor WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'"));

        //queri filter data
        $data_sensor = select("SELECT * FROM tb_sensor WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id DESC LIMIT $awalData, $jumlahDataPerhalaman");

    }else{

        $data_sensor = select("SELECT * FROM tb_sensor ORDER BY id DESC LIMIT $awalData, $jumlahDataPerhalaman");

    }



    $sqloFPompa = mysqli_query($konek, "SELECT * FROM tb_pompa");
    $dataOfPompa = mysqli_fetch_array($sqloFPompa);
    $ofPompa=$dataOfPompa ['nilai'];

    $sql = mysqli_query($konek, "SELECT * FROM tb_kontrol");
    $dat = mysqli_fetch_array($sql);
    $relay=$dat ['relay'];

    $sqll=mysqli_query($konek,"select * from tb_bataslembabtanah");
    $dta=mysqli_fetch_array($sqll);
    $noid=$dta ['id'];
    $nilaimaxKT=$dta ['kelembaban'];

    if(isset($_POST['btnUbah']))
    {

        // simpan kedalam kedatabase
        $ubah = mysqli_query($konek, "UPDATE tb_bataslembabtanah set kelembaban = '$_POST[iklb]'");

        if($ubah){
            echo "<script>
                    alert('Ubah data Sukses!');
                    document.location='index.php';
                    </script>";
        }else{
            echo "<script>
                    alert('Ubah data Sukses!');
                    document.location='index.php';
                    </script>";
        }
    }

    //jadwal penyiraman
    if(isset($_POST['btnSimpan']))
    {
        $jam = $_POST['jam'];
        $status= 0;

        // simpan kedalam kedatabase
        // supaya id selalu dimulai awal
        mysqli_query($konek, "ALTER TABLE tb_jam AUTO_INCREMENT=1");
        $simpan = mysqli_query($konek, "INSERT INTO tb_jam(jam, status)values('$jam', '$status')");

        if($simpan){
            echo "<script>
                    alert('Simpan data Sukses!');
                    document.location='index.php';
                    </script>";
        }else{
            echo "<script>
                    alert('simpan data Sukses!');
                    document.location='index.php';
                    </script>";
        }
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>


    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.rtl.min.css" integrity="sha384-T5m5WERuXcjgzF8DAb7tRkByEZQGcpraRTinjpywg37AO96WoYN9+hrhDVoM6CaT" crossorigin="anonymous"> -->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <title>IoT-Sistem Monitoring Kelembaban Tanah</title>

    <script type="text/javascript">
        function ubahstatus(value)
        {
            if(value==true) value = "ON";
            elsevalue= "OFF";
            document.getElementById('status').innerHTML = value;

            // ajax  untuk merubah nilai status relay
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange= function()
            {
                if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    // ambil respon dari web nya setelah berhasil merubah nilai
                    document.getElementById('status').innerHTML = xmlhttp.responseText;
                }
            }
            // exsecute file php untukmerubah nilai di database
            xmlhttp.open("GET", "relay.php?stat=" + value, true);
            // kirim data
            xmlhttp.send();

        }

        function ubahofPompa(valueofPompa)
        {
            if(valueofPompa==true) valueofPompa = "ON";
            elsevalueofPompa= "OFF";
            document.getElementById('statusofPompa').innerHTML = valueofPompa;

            // ajax  untuk merubah nilai status relay
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange= function()
            {
                if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    // ambil respon dari web nya setelah berhasil merubah nilai
                    document.getElementById('statusofPompa').innerHTML = xmlhttp.responseText;
                }
            }
            // exsecute file php untukmerubah nilai di database
            xmlhttp.open("GET", "ofPompa.php?statusOfPompa=" + valueofPompa, true);
            // kirim data
            xmlhttp.send();

        }
    </script>

    <!-- Real TIme -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.rtl.min.css">
    <script type="text/javascript"  src="jquery/jquery-3.4.0.min.js"></script>
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <script type="text/javascript" src="jquery/jquery-latest.js"></script>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


    <!-- ajax untuk proses real time -->
    <script type="text/javascript">
        var refreshid = setInterval
        (function(){
                $("#data").load('js/demo/chart-area-demo.php');
                $("#dataJam").load('cekJam.php');
                $("#nilaiKT").load('nilaiKT.php');
                $("#cekSuhu").load('ceksuhu.php');
                $("#cekKelembabanUdara").load('cekkelembabanudara.php');
            }, 1000);
        
    </script>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <!-- <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar"> -->

            <!-- Sidebar - Brand -->
            <!-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="sidebar-brand-text mx-3" style="font-size: 12px">Smart-F </div>
            </a> -->

            <!-- Divider -->
            <!-- <hr class="sidebar-divider my-0 " style="color:white;"> -->

            <!-- Nav Item - Dashboard -->
            <!-- <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li> -->

            <!-- <hr class="sidebar-divider my-0"> -->

            <!-- <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Data Sensor</span></a>
            </li>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Grafik</span></a>
            </li> -->



            <!-- Divider -->
            <!-- <hr class="sidebar-divider d-none d-md-block"> -->

            <!-- Sidebar Toggler (Sidebar) -->
            <!-- <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul> -->
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-primary topbar mb-4 static-top shadow">
                    <a class="navbar-brand text-light  href="index.php">Sistem Monitoring Kelembaban Tanah</a>
                    <span class="navbar-brand text-light me-auto mb-2 mb-lg-0" style="text-align: right;" id="dataJam"></span>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <h4 class="font-weight-bold" style="align: center;"><div id="dataJam"></div></h4>
                    </div> -->

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-3">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">

                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 36px;" id="nilaiKT"> %
                                                
                                            </div>
                                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">
                                                Kelembaban Tanah
                                            </div>
                                            
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-thermometer-half fa-4x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-4 col-md-6 mb-3">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 36px;">
                                                <span id="cekSuhu"> °C</span>
                                            </div>
                                            <div class="text-sm font-weight-bold text-success text-uppercase mb-1">
                                                Suhu 
                                            </div>
                                            
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-thermometer-half fa-4x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <!-- <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-4 col-md-6 mb-3">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-sm font-weight-bold text-warning text-uppercase mb-1">
                                                Kontrol Sistem Irigasi</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" onchange="ubahstatus(this.checked)" <?php if($relay==1) echo "checked";?> >
                                                    <label class="form-check-label" for="flexSwitchCheckDefault" style="padding-left: 26px; padding-top: 4px;"> <span id="status"><?php if($relay==1) echo "ON"; else echo "OFF"; ?></span> </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-plug fa-4x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <div class="m-0 font-weight-bold text-primary text-sm">Grafik Sensor <em class="text-primary-300"> Real-time</em></div>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-1x text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Data Sensor</div>
                                            <a class="dropdown-item" href="#" data-toggle='modal' data-target='#modalData'>Tampilkan Data</a>
                                            
                                        </div>
                                    </div>
                                    <div class="modal fade" id="modalData" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:lightsteelblue;">
         <h4 class="modal-title" style="margin-right: 0px; font-size: 18px;">Data Sensor Kelembaban Tanah & Suhu Udara</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

        <div class="form-row ">
            <label for="tgl_awal" class="col-md-2 mr-2">Tanggal Awal</label>
            <label for="tgl_akhir" class="col-md-2 mr-2">Tanggal Akhir</label>
        </div>
        <form action="dataFilter.php" method="POST">
        <div class="form-row mb-2 ">
                <input type="date" name="tgl_awal" id="tgl_awal" class="form-control col-md-2 mr-2" >
                <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control col-md-2 mr-2">
        
            <button type="submit" class="btn btn-success btn-sm mr-2 btn-flt"  name="filter" id="filter"><i class="fas fa-search"></i> Filter Data</button>

            <!-- <div class="form-row mb-2 align-items-left">
        <label class="mr-2">Shows  </label>
        <input type="number" name="shows" class="form-control col-md-3 mr-2">
            </div> -->
        </div>
    </form>

    
    <table class="table table-bordered table-sm table-hover" style="text-align: center; margin-bottom: 0px;">
                                    <thead>
                                    <tr height="20px" class="bg-dark" style=" color: white;">
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">No</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Kelembaban Tanah</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Suhu</th>
                                        <th colspan="2" >Waktu</th>
                                    </tr>
                                    <tr class="bg-dark" style=" color: white;">
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data_sensor as $sensor): ?>
                                        <tr>
                                            <td><?php echo $awalData += 1; ?></td>
                                            <td><?php echo $sensor ['nilai_sensor']; ?></td>
                                            <td><?php echo $sensor ['nilai_sensor']; ?></td>
                                            <td><?php $timestamp = $sensor ['tanggal'];
                                            echo date('M d<\s\u\p>S</\s\u\p>, Y',strtotime($timestamp)); ?></td>
                                            <td><?php $timestamp = $sensor ['tanggal'];
                                            echo date('h:i:s',strtotime($timestamp)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                   </table>
       

      </div>
      <div class="modal-footer">
        <!-- pagination -->
                            <div class="mt-2 justify-content-end d-flex">
                            <nav aria-label="Page navigation example">
                              <ul class="pagination">
                                <?php if($halamanAktif > 1): ?>
                                <li class="page-item">
                                  <a class="page-link" href="?halaman= <?= $halamanAktif - 1?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                  </a>
                                </li>
                            <?php endif; ?>

                            <?php for($i = $startNumber; $i <= $endNumber; $i++ ): ?>
                                <?php if($i == $halamanAktif) : ?>
                                <li class="page-item active"><a class="page-link" href="dataFilter.php?halaman= <?= $i; ?>"><?= $i; ?></a></li>
                            <?php else: ?>
                                <li class="page-item "><a class="page-link" href="dataFilter.php?halaman= <?= $i; ?>"><?= $i; ?></a></li>
                            <?php endif; ?>
                            <?php endfor; ?>

                               <!--  <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li> -->

                                <?php if($halamanAktif < $jumlahHalaman): ?>
                                <li class="page-item">
                                  <a class="page-link" href="?halaman= <?= $halamanAktif + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                  </a>
                                </li>
                            <?php endif; ?>
                              </ul>
                            </nav>
                                   </div>
                                   <!-- akhir pagination -->
      </div>
    </div>
  </div>
</div>
<!-- akhir modalData -->

</div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="text-center" style="font-size: 11px;">
                                        <i class='fas fa-bowling-ball text-primary text-sm' style=''> Kelembaban Tanah </i>
                                        <i class='fas fa-bowling-ball text-success text-sm' style=''> Suhu </i>
                                        <i class='fas fa-bowling-ball text-warning text-sm' style=''> Kelembaban Udara </i>
                                    </div>
                                    <div class="chart-area" id="data">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-info text-sm">Penjadwalan Sistem Irigasi </h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-stopwatch fa-2x text-gray-400"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- switch -->
                                        
                                      <!-- Trigger the modal with a button -->
                                      <button type="button" class="btn btn-info btn-sm " data-toggle="modal" data-target="#mymodal"><i class="fas fa-plus">       </i>        Tambah Data</button>

                                      <!-- Modal -->
                                      <div class="modal fade" id="mymodal" role="dialog">
                                        <div class="modal-dialog">
                                        
                                          <!-- Modal content-->
                                          <div class="modal-content">
                                            <form method="POST">
                                            <div class="modal-header" style="background-color:lightsteelblue;">
                                                <h4 class="modal-title" style="margin-right: 0px; font-size: 18px;">Penjadwalan Sistem Irigasi</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Input Data Jam</p>
                                              <input type="time" step="1" value="00:00:00" name="jam" id="jam" class="form-control" placeholder="JAM:MENIT:DETIK" requered style="text-align: center; font-size:12px;">
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                              <button type="submit" name="btnSimpan" id="btnSimpan" class="btn btn-info btn-sm">SIMPAN</button>
                                            </div>
                                        </form>
                                          </div>
                                        </div>
                                      </div>
                                    
                                    <!-- Tabel Data Jam Tersimpan -->
                                    <div style="margin-top:5px; overflow-y:auto; height: 248px;">
                                    <table class="table table-bordered table-fixed " style="text-align: center; margin-bottom: 0px; ">
                                        <thead>
                                        <tr class="bg-dark" style=" color: white;">
                                            <th>List Jam</th>
                                            <th style="width: 10px;">Aksi</th>
                                        </tr>
                                        </thead>
                                        <?php 
                                        //baca isi tabel jam
                                        $sqlJam = mysqli_query($konek, "SELECT * FROM tb_jam order by id asc");
                                        while($datt = mysqli_fetch_array($sqlJam))
                                        {
                                         ?>
                                        <tbody style="overflow-y:auto;">
                                            <tr>
                                            <td><?php echo $datt ['jam']; ?></td>
                                            <td>
                                                <a href="hapusJam.php?id=<?php echo $datt['id'];?>">
                                                <i class="fa fa-trash" style="color: indianred;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </table>
                                </div>

                                <div class="container" style="margin-top: 5px; margin-right: 1;">
                                        

                                      <!-- Trigger the modal with a button -->
                                      <input class="form-check-input" type="checkbox" role id="statusofPompa" onchange="ubahofPompa(this.checked)" <?php if($ofPompa==1) echo "checked";?> >

                                      <em class="text-bold" style="font-size:14px; color: grey;"><strong>Automatically, </strong>         </em><a style="font-size:14px; color: grey;"><em>turn OFF</em></a>
                                      <u type="button" data-toggle="modal" data-target="#modalsaya" class="m-0 font-weight-bold text-info" style="font-size:14px;">><?php echo $nilaimaxKT; ?>%.</u>

                                      <!-- Modal -->
                                      <div class="modal fade" id="modalsaya" role="dialog">
                                        <div class="modal-dialog">
                                        
                                          <!-- Modal content-->
                                          <div class="modal-content">
                                            <form method="POST">
                                            <div class="modal-header" style="background-color:lightsteelblue;">
                                                <h4 class="modal-title" style="margin-right: 0px; font-size: 18px;">Pengaturan Pompa Otomatis <em class="text-danger"> OFF</em></h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                              <p>Nilai Kelembaban Tanah</p>
                                              <input type="text" name="iklb" value="<?php echo $dta['kelembaban']; ?>" class="form-control">
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                              <button type="submit" name="btnUbah"  class="btn btn-danger btn-sm">UBAH</button>
                                            </div>
                                        </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <!-- <div class="row"> -->

                        <!-- Content Column -->
                        <!-- <div class="col-lg-12 mb-4"> -->

                            <!-- Project Card Example -->
                            <!-- <div class="card shadow mb-3">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Data Kelembaban & Suhu Udara</h6>
                                </div>
                                <div class="card-body">
                                    
                                </div>
                            </div> -->
                        <!-- </div></div> -->
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white height-5">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>T.A Abdul Jalil Maulani 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.php"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script type="text/javascript">
        document.querySelector('btn-flt').addEventListener('click', () => {
            window.location.replace('dataFilter.php');
        });
    </script>

</body>

</html>