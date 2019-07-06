<?php 
include_once 'config/db.php';
include_once 'ceklogin.php';
    
    $userrole  = $_SESSION['role'];
    define ('SITE_ROOT', realpath(dirname(__FILE__)));
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    $gagal=0;
    $sukses=0;
    $pesan="";
    
    if (!empty($_POST)) {
        $tahun= $_POST['tahun'];
        $sql1= mysqli_query($link,"SELECT count(npsn) as jumlah FROM pengajuanrka WHERE ta='$tahun'");
        $datalama=mysqli_fetch_array($sql1);
        // echo "data lama=".$datalama['jumlah']."<br>";
        $pesan.="Data Lama: ".$datalama['jumlah'];
        if($datalama['jumlah']>0){
            $hapus=mysqli_query($link,"DELETE FROM pengajuanrka WHERE ta='$tahun'");
            if ($hapus) {
                # code...
                // echo "data lama terhapus<br>";
                $pesan.=". Data Lama Terhapus";
            }
        }
        $targetPath = 'pengajuan/'.$_FILES['file']['name'];
        $FileType = strtolower(pathinfo($targetPath,PATHINFO_EXTENSION));
        if ($FileType=="xlsx") {
            # code...
            move_uploaded_file($_FILES['file']['tmp_name'], SITE_ROOT."/".$targetPath);
            // $helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using ' . Xls::class);
            $reader = new Xlsx();
            // $spreadsheet = $reader->load($inputFileName);
            $spreadsheet = $reader->load($targetPath);

            $worksheet = $spreadsheet->getActiveSheet();
            // $worksheet = $spreadsheet->getSheetByName('rekonweb');
            // Get the highest row and column numbers referenced in the worksheet
            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            // $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            // $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5
            $highestColumnIndex=7;
            // echo '<table>' . "\n";
            $sql="";
            $sql.="INSERT INTO pengajuanrka(
                ta, 
                npsn, 
                belanja_pegawai, 
                belanja_barangjasa, 
                belanja_modal
            ) VALUES ";
            for ($row = 2; $row <= $highestRow; ++$row) {
                // echo '<tr>' . PHP_EOL;
                $sql.="('$tahun',";
                for ($col = 2; $col < $highestColumnIndex; ++$col) {
                    if ($col==3) continue; 
                    $value = $worksheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();
                    $sql.="'".$value."'";
                    if($col<($highestColumnIndex)-1) $sql.=",";
                    // echo '<td>' . $value . '</td>' . PHP_EOL;
                }
                $sql.=")";
                if($row!=$highestRow) $sql.=",";
                // echo '</tr>' . PHP_EOL;
            }
            // echo '</table>' . PHP_EOL;
            // echo $sql;
            $result=mysqli_query($link,$sql);
            if($result){
                // echo "<br>Sukses";
                $sukses=1;
                $pesan.=". Sukses, data baru berhasil ditambahkan.";
            }
            else{
                $gagal=1;
                $pesan.=". Maaf, data gagal ditambahkan.";
            }
        }
        else{
            $gagal=1;
            $pesan.=". Maaf, hanya file xlsx yang dapat diproses";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/x-icon" sizes="16x16" href="assets/images/favicon.ico">
    <title>Import Pengajuan - <?php echo $namaweb;?></title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="assets/css/colors/<?php echo $warnaweb;?>.css" id="theme" rel="stylesheet">
    <link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <style type="text/css">
        .h1special {
            font-size: 1.5rem;
            margin-top: 10px;
        }
        .logospecial {
            height: 70px;
        }

        @media (min-width: 1024px) {
            .h1special {
                font-size: 2.5rem;
                margin-top: 10px;
            }
            .logospecial {
                height: 70px;
            }
        }
    </style>
</head>

<body class="fix-header card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php 
            include_once 'include/header.php';
        ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php  
            include_once 'include/left-sidebar.php';
        ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Import Pengajuan</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Import Pengajuan</li>
                    </ol>
                </div>
                <!-- <div>
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div> -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                
                <div class="row justify-content-md-center">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="text-center text-md-left db">
                                            <img src="assets/images/semarangkab.png" class="logospecial">
                                            <h1 class="h1special pull-right d-none d-md-block">Pengajuan RKA</h1>
                                        </div> 
                                    </div>
                                </div>
                                <hr>

                                <form method="POST" action="" enctype="multipart/form-data">

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-3 col-form-label">Tahun</label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="number" name="tahun" value="2019">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-3 col-form-label">File</label>
                                        <div class="col-md-9">
                                            <input class="form-control" name="file" type="file">
                                            <small class="form-control-feedback"> Sebelum upload, pastikan file excel yang diupload bertipe Xlsx </small>
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
                                        
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h3>Template XLSX</h3>
                                <hr>
                                <p class="text-justify">Silahkan mengunduh format pengajuan RKA dalam bentuk excel berikut</p>
                                <div class="text-center">
                                    <a href="format/formatpengajuanrka.xlsx">
                                        <button type="button" class="btn btn-success">
                                            <i class="mdi mdi-download"></i>Download
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php  
                include_once 'include/footer.php';
            ?>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>

    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.min.js"></script>
    <!-- Sweet-Alert  -->
    <script src="assets/plugins/sweetalert/sweetalert2.min.js"></script>
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script>
        
        function logout() {
            // body...
             swal({
              title: "Yakin akan keluar?",
              // text: "Saat anda keluar pekerjaan yang belum anda submit akan hilang!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((logout) => {
              if (logout) {
                swal("Logout berhasil", {
                  icon: "success",
                }).then(function() {window.location = "logout.php";});
              }
            });
        }
    </script>
    
</body>

</html>
