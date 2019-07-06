<?php 
include_once 'config/db.php';
include_once 'ceklogin.php';
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
    <title>Belanja Modal - <?php echo $namaweb;?></title>
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
                    <h3 class="text-themecolor">Belanja Modal</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Belanja Modal</li>
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="text-center text-md-left db">
                                            <img src="assets/images/semarangkab.png" class="logospecial">
                                            <h1 class="h1special pull-right d-none d-md-block">Belanja Modal</h1>
                                        </div> 
                                    </div>
                                </div>
                                <hr>
                                <form action="">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <a data-toggle="collapse" href="#tabelinv" role="button" aria-expanded="false" aria-controls="collapseExample" class="col-lg-4 col-form-label text-dark">Kode Belanja</a>
                                                <div class="col-lg-8">
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" id="noregister" name="noreg" placeholder="Masukkan Kode Belanja">
                                                        <div class="input-group-append">
                                                            <button type="button" data-toggle="modal" data-target="#modalinvestasi" class="btn">. . .</button>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>              
                                        </div>
                                        <div class="col-lg-6">
                                            
                                            <button class="btn btn-info">Proses</button>
                                        </div>
                                        
                                    </div>
                                </form>
                                
                                <div class="collapse" id="tabelinv">
                                    <table class="table table-bordered color-bordered-table info-bordered-table">
                                        <thead>
                                            <th>Tanggal</th>
                                            <th>Kode Belanja</th>
                                            <th>Belanja</th>
                                            <th>Harga</th>
                                            <th>Program</th>
                                            <th>Kode Pembiayaan</th>
                                            <th>No Rekening</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>          
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-lg-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Pengadaan Barang</h4></div>
                            <div class="card-body">
                                <form action="" method="POST">
                                <div class="card-body">
                                    
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-3 col-form-label">Nama Barang</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" name="namabarang" placeholder="Masukkan Nama Barang">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-3 col-form-label">Merk</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" name="merk" placeholder="Masukkan Merk">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-3 col-form-label">Type</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" name="type" placeholder="Masukkan Type">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-3 col-form-label">Bahan</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" name="bahan" placeholder="Masukkan Bahan">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-3 col-form-label">Bukti Pembelian</label>
                                        <div class="col-lg-9">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="bahan" placeholder="Masukkan Tanggal">
                                                <input class="form-control" type="text" name="bulan" placeholder="Masukkan bulan">
                                                <input class="form-control" type="text" name="nomor" placeholder="Masukkan nomor">
                                                
                                            </div>
                                        </div>


                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-3 col-form-label">Jumlah</label>
                                        <div class="col-lg-9">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="jumlahbarang" placeholder="Masukkan Jumlah Barang">
                                                <input class="form-control" type="text" name="satuan" placeholder="Masukkan satuan">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-3 col-form-label">Harga</label>
                                        <div class="col-lg-9">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="hargasatuan" placeholder="Masukkan hargasatuan">
                                                <input class="form-control" type="text" name="jumlahharga" placeholder="jumlah harga" readonly="">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-info"><i class="fa fa-upload"></i> Simpan</button>
                                        </div>
                                    </div> 

                                </div>
                                
                                
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Data Pengadaan Barang</h4></div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered" id="tabelbelanjamodal">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Merk</th>
                                            <th>Type</th>
                                            <th>Bahan</th>
                                            <th>Tanggal</th>
                                            <th>Bulan</th>
                                            <th>Nomor</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td>a</td>
                                        <td>a</td>
                                        <td>a</td>
                                        <td>a</td>
                                        <td>a</td>
                                        <td>a</td>
                                        <td>a</td>
                                        <td>a</td>
                                        <td>a</td>
                                        <td>a</td>
                                        <td>a</td>
                                        
                                    </tr>
                                </table>
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
        $(document).ready(function(){
            $('#tabelbelanjamodal').DataTable();
        });
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
