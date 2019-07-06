<?php 
    include_once 'config/db.php';
    include_once 'ceklogin.php';
    include_once 'config/belanja.php';

    $userrole   = $_SESSION['role'];
    $usernpsn   = ($userrole==2) ? $_SESSION['username'] : "" ;
    
    define ('SITE_ROOT', realpath(dirname(__FILE__)));
    $gagal=0;
    $sukses=0;
    $pesan="";

    if (!empty($_POST)) {
        $tanggalbelanja = $_POST['tanggalbelanja'];
        $tanggalbelanja = strtotime($tanggalbelanja);
        $tanggalbelanja = date("Y-m-d" ,$tanggalbelanja);
        $npsn           = $_POST['npsn'];
        $tahun          = $_POST['tahun'];
        $triwulan       = $_POST['triwulan'];
        $belanja        = $_POST['belanja'];
        $hargabelanja   = ParseFloat($_POST['hargabelanja']);
        $idprogram      = $_POST['idprogram']; 
        $idkomponen     = $_POST['idkomponen']; 
        $idrekening     = $_POST['idrekening'];
        $keterangan     = $_POST['keterangan'];

        $pagu = limitrka($tahun, $triwulan, $npsn);
        $saldo = saldotriwulan($tahun, $triwulan, $npsn);
        
        $kodeparent = getparent($idrekening);
        $kategori = kategoribelanja($kodeparent);
        $pagubelanja= $pagu[$kategori];
        // $saldobelanja= $saldo[$kategori];
        $saldobelanja= $saldo["saldo"];


        if ($hargabelanja <= $saldobelanja) {
            if ($hargabelanja <= $pagubelanja) {
                $tambahbelanja  = mysqli_query($link,"INSERT INTO belanja (ta,triwulan,npsn,belanja,harga,tanggal_belanja,kode_program,kode_pembiayaan,kode_rekening,keterangan)
                    VALUES
                    ('$tahun','$triwulan','$npsn','$belanja','$hargabelanja','$tanggalbelanja','$idprogram','$idkomponen','$idrekening','$keterangan')"
                );
                if ($tambahbelanja) {
                    $update=updatesisatriwulan($tahun, $triwulan, $npsn, $kategori, $hargabelanja);
                }
            }   
        }

        // upload
        /*
        while (1) {
            $targetPath = 'nota/'.$_FILES['file']['name'];
            $FileType = strtolower(pathinfo($targetPath,PATHINFO_EXTENSION));
            if ($FileType=="pdf" || $FileType=="png" || $FileType=="jpg" || $FileType=="jpeg") {
                if(move_uploaded_file($_FILES['file']['tmp_name'], SITE_ROOT."/".$targetPath)){
                    $tambahdata= mysqli_query($link, "INSERT INTO belanja
                        () VALUES 
                        ()");
                    if ($tambahdata) {

                    }
                    else{

                    }
                }
                else{
                    $gagal=1;
                    $pesan.=" Maaf, File Nota Gagal diupload ";
                }

            }
            else{
                $gagal=1;
                $pesan.=" Maaf, hanya file PDF/PNG/JPG/JPEG yang dapat diproses ";
            }
        }
        */
    

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
    <title>Tambah Belanja - <?php echo $namaweb;?></title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="assets/css/colors/<?php echo $warnaweb;?>.css" id="theme" rel="stylesheet">
    <link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <style type="text/css">
        @font-face {
          font-family: 'Roboto Mono';
          src: URL('assets/fonts/RobotoMono-Regular.ttf') format('truetype');
        }
        .mask, .mono{
            font-family: 'Roboto Mono';
        }
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
                    <h3 class="text-themecolor">Tambah Belanja</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Belanja</li>
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
            <?php 
                include_once 'config/lookupprogram.php';
                include_once 'config/lookupkomponen.php';
                include_once 'config/lookuprekening2.php';
            ?>
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                
                <div class="row justify-content-md-center">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="text-center text-md-left db">
                                            <img src="assets/images/semarangkab.png" class="logospecial">
                                            <h1 class="h1special pull-right d-none d-md-block">Belanja Dana BOS</h1>
                                        </div> 
                                    </div>
                                </div>
                                <hr>

                                <!-- <form method="POST" action="" enctype="multipart/form-data"> -->
                                <form method="POST" action="">
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-4 col-form-label">NPSN</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" type="number" name="npsn" placeholder="Masukkan NPSN" value="<?php echo $usernpsn;?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-4 col-form-label">TA</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" type="number" name="tahun" placeholder="Masukkan Tahun Anggaran" value="<?php echo $ta;?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-4 col-form-label">Triwulan</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" type="number" name="triwulan" placeholder="Masukkan Triwulan" value="<?php echo $tw;?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-4 col-form-label">Tanggal</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" type="text" id="tanggal-belanja" name="tanggalbelanja" placeholder="Masukkan Tanggal Belanja">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-4 col-form-label">Belanja</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" type="text" name="belanja" placeholder="Masukkan Belanja">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-4 col-form-label">Harga</label>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text mono">Rp</span>
                                                </div>
                                                <input class="mask form-control" data-inputmask="'alias': 'rupiah'" type="text" name="hargabelanja" placeholder="Masukkan Harga Belanja">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-4 col-form-label">Program</label>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="namaprogram" placeholder="Pilih Program" id="namaprogram" readonly="">
                                                <input id="idprogram" name="idprogram" type="text" hidden="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modalprogram">. . .</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-4 col-form-label">Kode Pembiayaan</label>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="namakomponen" placeholder="Pilih Kode Pembiayaan" id="namakomponen" readonly="">
                                                <input id="idkomponen" name="idkomponen" type="text" hidden="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#modalkomponen">. . .</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-4 col-form-label">Kode Rekening</label>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="namarekening" placeholder="Pilih Kode Rekening" id="namarekening" readonly="">
                                                <input id="idrekening" name="idrekening" type="text" hidden="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalrekening">. . .</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-4 col-form-label">Keterangan</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" type="text" name="keterangan" placeholder="Masukkan Keterangan">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group row">
                                        <label for="example-text-input" class="col-md-4 col-form-label">File Nota</label>
                                        <div class="col-md-8">
                                            <input class="form-control" name="file" type="file">
                                            <small class="form-control-feedback"> Sebelum upload, pastikan file nota yang diupload bertipe PDF/PNG/JPG/JPEG </small>
                                        </div>
                                    </div> -->
                                    
                                    <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
                                        
                                </form>

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
    <script src="assets/js/jquery.inputmask.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.min.js"></script>
    <!-- Sweet-Alert  -->
    <script src="assets/plugins/sweetalert/sweetalert2.min.js"></script>
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/moment/moment.js"></script>
    <script src="assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    
    <script>
        $(function () {
            $(document).on('click', '.pilihprogram', function (e) {
                document.getElementById("namaprogram").value = $(this).attr('data-namaprogram');
                document.getElementById("idprogram").value = $(this).attr('data-idprogram');
                $('#modalprogram').modal('hide');
            });

            $(document).on('click', '.pilihkomponen', function (e) {
                document.getElementById("namakomponen").value = $(this).attr('data-namakomponen');
                document.getElementById("idkomponen").value = $(this).attr('data-idkomponen');
                $('#modalkomponen').modal('hide');
            });

            $(document).on('click', '.pilihrekening', function (e) {
                document.getElementById("namarekening").value = $(this).attr('data-namarekening');
                document.getElementById("idrekening").value = $(this).attr('data-idrekening');
                $('#modalrekening').modal('hide');
            });

            $('#tanggal-belanja').bootstrapMaterialDatePicker({
                'format': 'DD MMMM YYYY',
                'time': false  
            }).change();

            Inputmask.extendAliases({
                'rupiah': {
                    // prefix: " ",
                    removeMaskOnSubmit: true,
                    groupSeparator: ".",
                    radixPoint: ",",
                    alias: "numeric",
                    placeholder: "0",
                    autoGroup: true,
                    digits: 2,
                    digitsOptional: false
                }
            });

            $(".mask").inputmask();
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
