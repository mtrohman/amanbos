<?php 
include_once 'config/db.php';
include_once 'config/dbmanager.php';
include_once 'ceklogin.php';
use App\Models\Sekolah;
use App\Models\Pagu;
use App\Models\Belanja;
use App\Models\Pencairan;
use App\Models\Pengumuman;

$allpengumuman= Pengumuman::all();

if ($_SESSION['role']==1) {
    # code...
    $countsekolah= Sekolah::count();
    $totalpagu= Pagu::ta($_SESSION['ta'])->sum('pagu');
    $totalbelanja= Belanja::ta($_SESSION['ta'])->sum('nilai');
    $totalpencairan= Pencairan::ta($_SESSION['ta'])->sum('saldo');
}
else{
    $datasekolah= Sekolah::npsn($_SESSION['username'])->first();
    // echo json_encode($datasekolah);
    $jumlahpagu= $datasekolah->pagus()->ta($_SESSION['ta'])->sum('pagu');
    $saldothlalu= $datasekolah->saldos()->ta($_SESSION['ta']-1)->sum('sisa');
    $saldothberjalan= $datasekolah->saldos()->ta($_SESSION['ta'])->sum('sisa');
    $belanja= Belanja::npsn($_SESSION['username'])->ta($_SESSION['ta'])->get();
    $totalbelanja= $belanja->sum('nilai');
    // $rkasekolah= $datasekolah->rkas()->with('belanja')->get();
    // $totalbelanja= $rkasekolah->sum('belanja.nilai');
    // $totalbelanja= collect($rkasekolah)->sum('belanja.nilai');
    // echo $totalbelanja;
    // if (!empty($rkasekolah)) {
    //     // $totalbelanja=0;
    // }
    // else{
        // $totalbelanja= $rkasekolah->belanja()->ta($_SESSION['ta'])->sum('nilai');
    // }
    // echo json_encode($belanja);
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
    <title>Dasbor - <?php echo $namaweb;?></title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="assets/css/colors/<?php echo $warnaweb;?>.css" id="theme" rel="stylesheet">
    <link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <style>
        @font-face {
          font-family: 'Roboto Mono';
          src: URL('assets/fonts/RobotoMono-Regular.ttf') format('truetype');
        }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
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
                    <h3 class="text-themecolor">Dasbor</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dasbor</li>
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
                <div class="row">
                    <div class="col-12">
                        <?php 
                        if($_SESSION['role']==1){
                        ?>
                            <!-- row -->
                            <div class="row">
                                <!-- Column -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="d-flex flex-row">
                                            <div class="p-10 bg-info">
                                                <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                            <div class="align-self-center m-l-20">
                                                <h3 class="m-b-0 text-info"><?php echo $countsekolah;?></h3>
                                                <h6 class="text-muted m-b-0">Jumlah Sekolah</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <!-- Column -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="d-flex flex-row">
                                            <div class="p-10 bg-warning">
                                                <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                            <div class="align-self-center m-l-20">
                                                <h5 class="m-b-0 text-warning"><?=rupiah($totalpagu);?></h5>
                                                <h6 class="text-muted m-b-0">Jumlah Pagu</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <!-- Column -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="d-flex flex-row">
                                            <div class="p-10 bg-primary">
                                                <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                            <div class="align-self-center m-l-20">
                                                <h5 class="m-b-0 text-primary"><?=rupiah($totalbelanja);?></h5>
                                                <h6 class="text-muted m-b-0">Total Belanja</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <!-- Column -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="d-flex flex-row">
                                            <div class="p-10 bg-danger">
                                                <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                            <div class="align-self-center m-l-20">
                                                <h5 class="m-b-0 text-danger"><?=rupiah($totalpencairan);?></h5>
                                                <h6 class="text-muted m-b-0">Anggaran dicairkan</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                            </div>
                            <!-- /row -->
                        <?php
                        }
                        else{
                        ?>
                            <!-- row -->
                            <div class="row">
                                <!-- Column -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="d-flex flex-row">
                                            <div class="p-10 bg-info">
                                                <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                            <div class="align-self-center m-l-20">
                                                <h5 class="m-b-0 text-info"><?=rupiah($jumlahpagu);?></h5>
                                                <h6 class="text-muted m-b-0">Jumlah Pagu</h6></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <!-- Column -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="d-flex flex-row">
                                            <div class="p-10 bg-warning">
                                                <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                            <div class="align-self-center m-l-20">
                                                <h5 class="m-b-0 text-warning"><?=rupiah($saldothlalu);?></h5>
                                                <h6 class="text-muted m-b-0">Saldo Tahun Lalu</h6></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <!-- Column -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="d-flex flex-row">
                                            <div class="p-10 bg-primary">
                                                <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                            <div class="align-self-center m-l-20">
                                                <h5 class="m-b-0 text-primary"><?=rupiah($saldothberjalan);?></h5>
                                                <h6 class="text-muted m-b-0">Saldo Tahun Berjalan</h6></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                                <!-- Column -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="d-flex flex-row">
                                            <div class="p-10 bg-danger">
                                                <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                            <div class="align-self-center m-l-20">
                                                <h5 class="m-b-0 text-danger"><?=rupiah($totalbelanja);?></h5>
                                                <h6 class="text-muted m-b-0">Total Belanja</h6></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Column -->
                            </div>
                            <!-- /row -->
                        <?php
                        }
                        ?>
                        

                        <!-- row -->
                        <div class="row">
                            
                            <!-- Column -->
                            <div class="col-md-6 col-lg-4 col-xlg-2">
                                <div class="card card-inverse card-success">
                                    <div class="box text-center">
                                        <h6 class="text-white">Tahun Anggaran</h6>
                                        <h1 class="font-light text-white"><?php echo $ta;?></h1>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <div class="col-md-6 col-lg-4 col-xlg-2">
                                <div class="card card-inverse card-dark">
                                    <div class="box text-center">
                                        <h6 class="text-white">Triwulan</h6>
                                        <h1 class="font-light text-white"><?php echo $tw;?></h1>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            <div class="col-md-6 col-lg-4 col-xlg-2">
                                <div class="card card-inverse card-megna">
                                    <div class="box text-center">
                                        <h6 class="text-white">Username/NPSN</h6>
                                        <h1 class="font-light text-white"><?php echo $username;?></h1>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                            
                        </div>
                        <!-- /row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        Selamat Datang
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            Pengumuman
                                        </div>
                                        <table id="tablepengumuman" style="font-family: 'Roboto Mono', monospace;" class="dt table table-sm table-bordered ">
                                            <thead>
                                                <tr>
                                                    <th style="width: 25%!important;">Tanggal</th>
                                                    <th style="width: 60%!important;">Informasi</th>
                                                    <th>Pilihan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                foreach ($allpengumuman as $key => $pengumuman) {
                                            ?>
                                                <tr>
                                                    <td><?=$pengumuman->created_at->format('d-m-Y');?></td>
                                                    <td><?=$pengumuman->judul;?></td>
                                                    <td><button class="btn btn-sm btn-info openBtn" data-id="<?=$pengumuman->id;?>"data-judul="<?=$pengumuman->judul;?>">Lihat</button></td>
                                                </tr>
                                            <?php } ?>  
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modalpengumuman" tabindex="-1" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="judulpengumuman">Pengumuman</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
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

        $('.openBtn').on('click',function(){
            var judul = $(this).attr('data-judul');
            var dataurl= "config/pengumuman/getpengumuman.php?id="+$(this).attr('data-id');
            $('#judulpengumuman').html(judul);
            $('.modal-body').load(dataurl,function(){
                $('#modalpengumuman').modal({show:true});
            });
        });
    </script>
    
</body>

</html>
