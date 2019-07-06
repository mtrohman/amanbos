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
    <title>Data Pengajuan RKA - <?php echo $namaweb;?></title>
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
        @font-face {
          font-family: 'Roboto Mono';
          src: URL('assets/fonts/RobotoMono-Regular.ttf') format('truetype');
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
                margin-top: 20px;
            }
            .logospecial {
                height: 70px;
            }
        }
    </style>
    <?php 
    $role      = $_SESSION['role'];
    $npsn      = $_SESSION['username'];
    $filter    = "";
    if ($role!=1) {
        $filter=" AND p.npsn='$npsn'";
        echo "\n<style>\n";
        echo ".khususadmin { display:none; }";
        echo "\n</style>\n";
    }
    ?>
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
                    <h3 class="text-themecolor">Data Pengajuan RKA</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Data Pengajuan RKA</li>
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
                                <div class="table-responsive">
                                    <table id="tablepengajuan" style="font-family: 'Roboto Mono', monospace;  border: 2px solid #dee2e6;" class="dt table table-sm table-bordered table-hover nowrap">
                                        <thead class=" bg-light-extra" style="border: 2px solid #dee2e6;">
                                            <tr>
                                                <th rowspan="2" class="align-middle">NPSN</th>
                                                <th rowspan="2" class="align-middle">Nama Sekolah</th>
                                                <th rowspan="2" class="align-middle">TA</th>
                                                <th colspan="5" class="text-center" style="color: white;background-color: #007bff;">Triwulan 1</th>
                                                <th colspan="5" class="text-center" style="color: white; background-color: #ffc107">Triwulan 2</th>
                                                <th colspan="5" class="text-center" style="color: white; background-color: #6f42c1;">Triwulan 3</th>
                                                <th colspan="5" class="text-center" style="color: white; background-color: #fd7e14">Triwulan 4</th>
                                                <th rowspan="2" class="align-middle khususadmin">Pilihan</th>
                                            </tr>
                                            <tr>
                                                <th>B. Pegawai</th>
                                                <th>B. Barang Jasa</th>
                                                <th>B. Alat Mesin</th>
                                                <th>B. Aset Lainnya</th>
                                                <th>B. Gedung Bangunan</th>
                                                
                                                <th>B. Pegawai</th>
                                                <th>B. Barang Jasa</th>
                                                <th>B. Alat Mesin</th>
                                                <th>B. Aset Lainnya</th>
                                                <th>B. Gedung Bangunan</th>
                                                
                                                <th>B. Pegawai</th>
                                                <th>B. Barang Jasa</th>
                                                <th>B. Alat Mesin</th>
                                                <th>B. Aset Lainnya</th>
                                                <th>B. Gedung Bangunan</th>

                                                <th>B. Pegawai</th>
                                                <th>B. Barang Jasa</th>
                                                <th>B. Alat Mesin</th>
                                                <th>B. Aset Lainnya</th>
                                                <th>B. Gedung Bangunan</th>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $query="SELECT p.*, s.nama_sekolah FROM pengajuanrka p NATURAL JOIN sekolah s WHERE p.ta=$ta".$filter;
                                                $sql = mysqli_query($link,$query);
                                                while ($r = mysqli_fetch_array($sql)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $r['npsn']; ?></td>
                                                <td><?php echo $r['nama_sekolah']; ?></td>
                                                <td><?php echo $r['ta']; ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t1_pegawai']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t1_barangjasa']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t1_alatmesin']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t1_asetlainnya']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t1_gedungbangunan']); ?></td>
                                                
                                                <td class="text-right"><?php echo rupiah($r['t2_pegawai']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t2_barangjasa']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t2_alatmesin']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t2_asetlainnya']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t2_gedungbangunan']); ?></td>
                                                
                                                <td class="text-right"><?php echo rupiah($r['t3_pegawai']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t3_barangjasa']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t3_alatmesin']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t3_asetlainnya']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t3_gedungbangunan']); ?></td>
                                                
                                                <td class="text-right"><?php echo rupiah($r['t4_pegawai']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t4_barangjasa']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t4_alatmesin']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t4_asetlainnya']); ?></td>
                                                <td class="text-right"><?php echo rupiah($r['t4_gedungbangunan']); ?></td>
                                                
                                                <td class="khususadmin">
                                                    <a href="editrka.php?id=<?php echo $r['id'];?>"><button class="btn btn-sm btn-info"><i class="mdi mdi-pencil"></i> Edit</button></a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
    <!-- DT -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/js/dtbutton/dataTables.buttons.js"></script>
    <script src="assets/js/dtbutton/jszip.js"></script>
    <script src="assets/js/dtbutton/pdfmake.js"></script>
    <script src="assets/js/dtbutton/vfs_fonts.js"></script>
    <script src="assets/js/dtbutton/buttons.html5.js"></script>
    <script src="assets/js/dtbutton/buttons.print.js"></script>
    
    <script>
        $(document).ready(function(){
            // $('#tablepengajuan thead tr').clone(true).appendTo( '#tablepengajuan thead' );
            // $('#tablepengajuan thead tr:eq(1) th').each( function (i) {
            //     var title = $(this).text();
            //     $(this).html( '<input class="form-control form-control-sm" type="text" placeholder="'+title+'" />' );
         
            //     $( 'input', this ).on( 'keyup change', function () {
            //         if ( table.column(i).search() !== this.value ) {
            //             table
            //                 .column(i)
            //                 .search( this.value )
            //                 .draw();
            //         }
            //     } );
            // } );
            var table = $('#tablepengajuan').DataTable( {
                // orderCellsTop: true,
                // dom: 'lrtip',
            } );
        });
    </script>
    <!-- DT -->
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
