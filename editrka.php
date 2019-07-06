<?php
include_once 'config/db.php';
include_once 'ceklogin.php';

if (!empty($_GET['id'])) {
    $idrka = $_GET['id'];
    $sqldatarka = "SELECT pr.*, s.nama_sekolah FROM pengajuanrka pr LEFT JOIN sekolah s ON pr.npsn=s.npsn WHERE id=" . $idrka;
    $fetchrka = mysqli_query($link, $sqldatarka);
    $datarka = mysqli_fetch_assoc($fetchrka);
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
    <title>Edit RKA - <?php echo $namaweb; ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="assets/css/colors/<?php echo $warnaweb; ?>.css" id="theme" rel="stylesheet">
    <link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
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

        .mask,
        .mono {
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
                    <h3 class="text-themecolor">Edit RKA</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Edit RKA</li>
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
                <form method="POST" action="">
                    <div class="row justify-content-md-center">

                        <div class="col-lg-12">

                            <!-- Info NPSN -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="text-center text-md-left db">
                                                <img src="assets/images/semarangkab.png" class="logospecial">
                                                <h1 class="h1special pull-right d-none d-md-block">Data RKA</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">NPSN</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="npsn" placeholder="Masukkan NPSN" value="<?php echo $datarka['npsn']; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">Sekolah</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="sekolah" placeholder="Masukkan Nama Sekolah" value="<?php echo $datarka['nama_sekolah']; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-md-2 col-form-label">TA</label>
                                        <div class="col-md-10">
                                            <input class="form-control" type="text" name="tahunanggaran" placeholder="Masukkan Tahun" value="<?php echo $datarka['ta']; ?>" readonly>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Info NPSN -->

                        </div>


                    </div>

                    <div class="row justify-content-md-center">
                        <div class="col-md-6">

                            <!-- Triwulan 1 -->
                            <div class="ribbon-wrapper card">
                                <div class="ribbon ribbon-info">Triwulan 1</div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Pegawai</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t1pegawai" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t1_pegawai']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Barang Jasa</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t1barangjasa" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t1_barangjasa']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Alat Mesin</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t1alatmesin" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t1_alatmesin']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Aset Lain</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t1asetlainnya" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t1_asetlainnya']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Gedung Bangunan</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t1gedungbangunan" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t1_gedungbangunan']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Triwulan 1 -->

                        </div>
                        <div class="col-md-6">
                            <!-- Triwulan 2 -->
                            <div class="ribbon-wrapper card">
                                <div class="ribbon ribbon-warning">Triwulan 2</div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Pegawai</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t2pegawai" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t2_pegawai']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Barang Jasa</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t2barangjasa" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t2_barangjasa']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Alat Mesin</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t2alatmesin" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t2_alatmesin']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Aset Lain</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t2asetlainnya" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t2_asetlainnya']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Gedung Bangunan</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t2gedungbangunan" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t2_gedungbangunan']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Triwulan 2 -->

                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-6">

                            <!-- Triwulan 3 -->
                            <div class="ribbon-wrapper card">
                                <div class="ribbon ribbon-primary">Triwulan 3</div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Pegawai</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t3pegawai" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t3_pegawai']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Barang Jasa</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t3barangjasa" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t3_barangjasa']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Alat Mesin</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t3alatmesin" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t3_alatmesin']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Aset Lain</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t3asetlainnya" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t3_asetlainnya']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Gedung Bangunan</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t3gedungbangunan" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t3_gedungbangunan']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Triwulan 3 -->

                        </div>
                        <div class="col-md-6">
                            <!-- Triwulan 4 -->
                            <div class="ribbon-wrapper card">
                                <div class="ribbon ribbon-danger">Triwulan 4</div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Pegawai</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t4pegawai" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t4_pegawai']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Barang Jasa</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t4barangjasa" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t4_barangjasa']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Alat Mesin</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t4alatmesin" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t4_alatmesin']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Aset Lain</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t4asetlainnya" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t4_asetlainnya']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-lg-4 col-form-label">B. Gedung Bangunan</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text mono">Rp</span>
                                            </div>
                                            <input class="form-control mask" data-inputmask="'alias': 'rupiah'" type="text" name="t4gedungbangunan" placeholder="Masukkan Anggaran" value="<?php echo $datarka['t4_gedungbangunan']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Triwulan 4 -->

                        </div>
                    </div>

                    <div class="row justify-content-md-center">

                        <div class="col-lg-12">
                            <div class="card">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-save"></i> Simpan
                                </button>
                            </div>
                        </div>

                    </div>

                </form>
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
    <script src="assets/js/jquery.inputmask.js"></script>
    <!-- Sweet-Alert  -->
    <script src="assets/plugins/sweetalert/sweetalert2.min.js"></script>
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
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
                        }).then(function() {
                            window.location = "logout.php";
                        });
                    }
                });
        }
    </script>

</body>

</html>