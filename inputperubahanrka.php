<?php
include_once 'config/db.php';
include_once 'ceklogin.php';

if (!empty($_POST)) {
    // var_dump($_POST);
    $tahun = $_POST['ta'];
    $triwulan = $_POST['triwulan'];
    $npsn = $_POST['npsn'];
    $kekurangan = ParseFloat($_POST['kekurangan']);
    $kelebihan = ParseFloat($_POST['kelebihan']);

    $sqlinsert = mysqli_query(
        $link,
        "INSERT INTO perubahanrka (
            npsn,
            ta,
            triwulan,
            tambahan_kekurangan,
            kelebihan_dikembalikan
        ) VALUES (
            '$npsn',
            '$tahun',
            '$triwulan',
            '$kekurangan',
            '$kelebihan'
        )"
    );
    if ($sqlinsert) {
        // echo "sukses";
        header("location: tabelperubahan.php");
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
    <title>Perubahan RKA - <?php echo $namaweb; ?></title>
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
                    <h3 class="text-themecolor">Perubahan RKA</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Perubahan RKA</li>
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
            <?php
            include_once 'config/lookupsekolah.php';
            ?>
            <!-- ============================================================== -->
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
                                            <h1 class="h1special pull-right d-none d-md-block">Data Perubahan</h1>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <form method="POST" action="">
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-5 col-form-label">Tahun Anggaran</label>
                                        <div class="col-lg-7">
                                            <input class="form-control" type="text" name="ta" placeholder="Masukkan TA" value="<?php echo $ta; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-5 col-form-label">Triwulan</label>
                                        <div class="col-lg-7">
                                            <!-- <input class="form-control" type="number" name="triwulan" placeholder="Masukkan Triwulan" value="<?php echo $tw; ?>" readonly> -->
                                            <select name="triwulan" id="trwln" class="form-control">
                                                <option value="0">Pilih Triwulan</option>
                                                <?php
                                                for ($i = 1; $i <= 4; $i++) {
                                                    $selectVal[$i] = ($tw == $i) ? "selected" : "";
                                                    echo "<option value='" . $i . "'" . $selectVal[$i] . ">" . $i . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-5 col-form-label">NPSN</label>
                                        <div class="col-lg-7">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="npsn" id="kodenpsn" placeholder="Masukkan NPSN" readonly>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalsekolah">. . .</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-5 col-form-label">Nama Sekolah</label>
                                        <div class="col-lg-7">
                                            <input class="form-control" type="text" name="sekolah" id="namasekolah" placeholder="Masukkan Nama Sekolah" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-5 col-form-label">Tambahan Kekurangan</label>
                                        <div class="col-lg-7">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text mono">Rp</span>
                                                </div>
                                                <input class="mask form-control" data-inputmask="'alias': 'rupiah'" type="text" name="kekurangan" placeholder="Masukkan Kekurangan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-lg-5 col-form-label">Kelebihan Dikembalikan</label>
                                        <div class="col-lg-7">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text mono">Rp</span>
                                                </div>
                                                <input class="mask form-control" data-inputmask="'alias': 'rupiah'" type="text" name="kelebihan" placeholder="Masukkan Kelebihan">
                                            </div>
                                        </div>
                                    </div>

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

            $(document).on('click', '.pilihsekolah', function(e) {
                document.getElementById("kodenpsn").value = $(this).attr('data-npsn');
                document.getElementById("namasekolah").value = $(this).attr('data-namasekolah');
                $('#modalsekolah').modal('hide');
            });
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