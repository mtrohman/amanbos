<?php 
    include_once 'config/db.php';
    if (isset($_SESSION['role'])) {
        # code...
        header('Location: index.php');
    }
    $yearnow=date("Y");
    $triwulan=triwulan(date("d-m-Y"));
    // echo triwulan($datenow);
    if (!empty($_POST)) {
        $username       = $_POST['uname'];
        $password       = $_POST['pword'];
        $ta             = $_POST['ta'];

        $cekuser=mysqli_query($link,"
            SELECT 
            id,
            nama,
            username,
            role
            FROM admin
            WHERE username='$username' AND password='$password'
            UNION ALL
            SELECT 
            id_sekolah as id,
            nama_sekolah as nama,
            npsn as username,
            role
            FROM sekolah
            WHERE npsn='$username' AND password='$password'
            
            ");
        $jml=mysqli_num_rows($cekuser);
        if ($jml==1) {
            $data=mysqli_fetch_array($cekuser);
            $_SESSION['id']         = $data['id'];
            $_SESSION['username']   = $data['username'];
            $_SESSION['role']       = $data['role'];
            $_SESSION['nama']       = $data['nama'];
            $_SESSION['ta']         = $ta;
            $_SESSION['triwulan']   = $triwulan;
            header('Location: index.php');
        }
        else{
            header('Location: ?err');
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
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.ico">
    <title>Login - <?php echo $namaweb;?></title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="assets/css/colors/blue.css" id="theme" rel="stylesheet">

</head>

<body>
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
    <section id="wrapper">
        <div style="padding: 25px; background-size: cover;
          background-repeat: no-repeat;
          background-position: center center;
          background-color: black;
          height: 100%;
          width: 100%;
          padding: 5% 0;
          position: fixed; 
          background-image:url(assets/images/goaview.jpg);
          ">
            <div class="login-box card">
                <div class="card-body">
                    <form class="form-horizontal form-material" method="POST" id="loginform" action="">
                	<a href="javascript:void(0)" class="text-center m-b-20 db"><img height="100px" src="assets/images/semarangkab.png" alt="Home" /><!-- <br/><img height="50px" src="assets/images/text-center.png" alt="Home" /> --></a>
                    <?php 
                        if (isset($_GET['k'])) {
                            ?>
                             <div class="alert alert-success alert-rounded"> <i class="ti-check"></i> Registrasi Berhasil, silahkan login.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            </div>
                            <?php
                        }
                    ?>
                    <?php 
                        if (isset($_GET['enter'])) {
                            ?>
                             <div class="alert alert-danger alert-rounded"> <i class="ti-lock"></i> Stop! Silahkan login dulu.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            </div>
                            <?php
                        }
                    ?>
                    <?php 
                        if (isset($_GET['err'])) {
                            ?>
                             <div class="alert alert-danger alert-rounded"> <i class="ti-na"></i> Username atau password salah.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                            </div>
                            <?php
                        }
                    ?>
                    <!-- <div class="alert alert-info alert-rounded"> <i class="ti-lock"></i> Untuk tamu silahkan gunakan username: tamu dan password: tamu
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    </div> -->
                    <h3 class="box-title m-t-0 m-b-0">Masuk Dahulu</h3><small>Silahkan masukkan username dan password anda dulu</small>

                    <div class="form-group m-t-20">
                        <div class="col-xs-12">
                            <input class="form-control" name="uname" type="text" required="" placeholder="Username">
                        </div>
                    </div>

                    <div class="form-group m-t-20">
                        <div class="col-xs-12">
                            <input class="form-control" name="pword" type="password" required="" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group m-t-20">
                        <div class="col-xs-12">
                            <input class="form-control" name="ta" type="number" required="" placeholder="Tahun Anggaran" value="<?php echo $yearnow;?>">
                        </div>
                    </div>
                    
                    
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>

                    </form>
                </div>
            </div>

        </div>
    </section>
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
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>