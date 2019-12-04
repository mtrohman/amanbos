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
    <title>Data Sekolah - <?php echo $namaweb;?></title>
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
    <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/material-teal/easyui.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/color.css">
	
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
                    <h3 class="text-themecolor">Data Sekolah</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Data Sekolah</li>
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
                                            <h1 class="h1special pull-right d-none d-md-block">Data Sekolah</h1>
                                        </div> 
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table id="dg" title="" class="easyui-datagrid" style="width:100%;height:400px"
                                        
                                        toolbar="#toolbar" pagination="true"
                                        rownumbers="true" fitColumns="false" singleSelect="true">
                                        <thead>
                                            <!-- <tr> -->
                                                <!-- <th field="npsn" width="100">NPSN</th>
                                                <th field="nama_sekolah" width="200">Nama Sekolah</th>
                                                <th field="jenjang" width="80">Jenjang</th>
                                                <th field="status" width="80">Status</th>
                                                <th field="kecamatan" width="150">Kecamatan</th>
                                                <th field="telepon" width="150">Telepon</th>
                                                <th field="nama_kepsek" width="150">Nama Kepsek</th>
                                                <th field="nip_kepsek" width="150">NIP Kepsek</th>
                                                <th field="nama_bendahara" width="150">Nama Bendahara</th>
                                                <th field="nip_bendahara" width="150">NIP Bendahara</th>
                                                <th field="alamat" width="300">Alamat</th> -->
                                            <!-- </tr> -->
                                        </thead>
                                        
                                    </table>
                                    <div id="toolbar" style="display: none">
                                        

                                    <?php
                                        if ($role==1) {
                                            ?>
                                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newSekolah()">Tambah</a>
                                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editSekolah()">Edit</a>
                                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroySekolah()">Hapus</a>
                                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-reload" plain="true" onclick="resetPassword()">Reset Password</a>
                                        <div>

                                            <span>npsn:</span>
                                            <input id="snpsn" style="line-height:26px;border:1px solid #ccc">
                                            <span>sekolah:</span>
                                            <input id="ssekolah" style="line-height:26px;border:1px solid #ccc">
                                            <span>kecamatan:</span>
                                            <input name="kecamatan" id="skecamatan" class="easyui-combobox" data-options="valueField:'id',textField:'nama_kecamatan',url:'config/sekolah/combobox_kecamatan.php'">

                                            <a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Cari</a>
                                        </div>
                                            <?php
                                        }
                                        else{
                                            ?>
                                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editSekolah()">Edit</a>
                                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroySekolah()">Hapus</a>
                                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editPassword()">Edit Password</a>

                                            <?php
                                        }
                                    ?>

                                        
                                    </div>
                                </div>

                                <div id="dlg" class="easyui-dialog" style="width:500px;max-width:80%;padding:10px 20px;" closed="true" buttons="#dlg-buttons">
                                    <!-- <div class="ftitle">User Information</div> -->
                                    <form id="fm" method="post">
                                        <div style="margin-bottom:10px">
                                            <input name="npsn" label="NPSN" id="fnpsn" class="easyui-textbox" labelWidth="150" style="width:100%">
                                        </div>
                                        <div style="margin-bottom:10px">
                                            <input name="nama_sekolah" label="Nama Sekolah" id="fnama_sekolah" class="easyui-textbox" labelWidth="150" style="width:100%">
                                        </div>
                                        <div style="margin-bottom:10px">
                                            <input name="jenjang" label="Jenjang" id="fjenjang"  labelWidth="150" style="width:100%"
                                            class="easyui-combobox" data-options="
                                            valueField: 'label',
                                            textField: 'value',
                                            data: [{
                                                label: 'SD',
                                                value: 'SD'
                                            },{
                                                label: 'SMP',
                                                value: 'SMP'
                                            }]" />
                                        </div>
                                        <div style="margin-bottom:10px">
                                            <input name="status" label="Status" id="fstatus" labelWidth="150" style="width:100%"
                                            class="easyui-combobox" data-options="
                                            valueField: 'label',
                                            textField: 'value',
                                            data: [{
                                                label: 'Negeri',
                                                value: 'Negeri'
                                            },{
                                                label: 'Swasta',
                                                value: 'Swasta'
                                            }]" />
                                        </div>
                                        
                                        <div style="margin-bottom:10px">
                                            <input name="kecamatan" label="Kecamatan" id="fkecamatan" labelWidth="150" style="width:100%" class="easyui-combobox" data-options="valueField:'id',textField:'nama_kecamatan',url:'config/sekolah/combobox_kecamatan.php'">
                                        </div>
                                        <div style="margin-bottom:10px">
                                            <input name="desa" label="Desa/Kelurahan" id="fdesa" class="easyui-textbox" labelWidth="150" style="width:100%">
                                        </div>
                                        <div style="margin-bottom:10px">
                                            <input name="alamat" label="Alamat" id="falamat" class="easyui-textbox" labelWidth="150" style="width:100%">
                                        </div>
                                        <div style="margin-bottom:10px">
                                            <input name="telepon" label="Telepon" id="ftelepon" class="easyui-numberbox" labelWidth="150" style="width:100%">
                                        </div>
                                        <?php
                                        if ($_SESSION['role']==1) {
                                            # code...
                                        ?>
                                            <div style="margin-bottom:10px">
                                                <input name="nama_kepsek" label="Nama Kepsek" id="fnama_kepsek" class="easyui-textbox" labelWidth="150" style="width:100%">
                                            </div>
                                            <div style="margin-bottom:10px">
                                                <input name="nip_kepsek" label="Nip Kepsek" id="fnip_kepsek" class="easyui-textbox" labelWidth="150" style="width:100%">
                                            </div>
                                            <div style="margin-bottom:10px">
                                                <input name="nama_bendahara" label="Nama Bendahara" id="fnama_bendahara" class="easyui-textbox" labelWidth="150" style="width:100%">
                                            </div>
                                            <div style="margin-bottom:10px">
                                                <input name="nip_bendahara" label="Nip Bendahara" id="fnip_bendahara" class="easyui-textbox" labelWidth="150" style="width:100%">
                                            </div>
                                        <?php
                                        }
                                        ?>    
                                        
                                        
                                    </form>
                                </div>
                                <div id="dlg-buttons">
                                    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveSekolah()" style="width:90px">Save</a>
                                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
                                </div>

                                <!-- Edit Password -->
                                <div id="dlgpw" class="easyui-dialog" style="width:500px;max-width:80%;padding:10px 20px;" closed="true" buttons="#dlgpw-buttons">
                                    <!-- <div class="ftitle">User Information</div> -->
                                    <div class="alert alert-danger" id="spanvalidasi" style="display: none">
                                    </div>
                                    <form id="fmpw" method="post">
                                        <div style="margin-bottom:10px">
                                            <input name="password_lama" type="password" label="Password Lama" id="fppasswordlama" class="easyui-textbox" labelWidth="170" style="width:100%" required="required">
                                        </div>
                                        <div style="margin-bottom:10px">
                                            <input name="password" type="password" label="Password Baru" id="fppasswordbaru" labelWidth="170" style="width:100%" class=" easyui-textbox" required="required">
                                        </div>
                                        <div style="margin-bottom:10px">
                                            <input name="konfirmasi" type="password" label="Konfirmasi Password" id="fppasswordkonfirmasi" labelWidth="170" style="width:100%" class=" easyui-textbox" required="required">
                                        </div>
                                    </form>
                                </div>
                                <div id="dlgpw-buttons">
                                    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="savePassword()" style="width:90px">Save</a>
                                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgpw').dialog('close')" style="width:90px">Cancel</a>
                                </div>
                                <!-- Edit Password -->

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
    <script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="http://www.jeasyui.com/easyui/plugins/jquery.datagrid.js"></script>
    
    <script>
        $(document).ready(function(){
            var npsn="<?=($_SESSION['role']==2) ? $_SESSION['username'] : '';?>";
            $('#dg').datagrid({
                url:"config/sekolah/getdata.php?npsn="+npsn,
                columns: [[
                    {field:"npsn", width:"100",title:"NPSN"},
                    {field:"nama_sekolah",width:"200",title:"Nama Sekolah"},
                    {field:"jenjang", width:"80", title:"Jenjang"},
                    {field:"status", width:"80", title:"Status"},
                    {field:"kecamatan", width:"150", title:"Kecamatan",formatter:function(value,row){return row.kecamatannya.nama_kecamatan;}},
                    {field:"desa", width:"150", title:"Desa"},
                    {field:"alamat", width:"200", title:"Alamat"},
                    {field:"telepon", width:"150", title:"Telepon"},
                    {field:"nama_kepsek", width:"150", title:"Nama Kepsek"},
                    {field:"nip_kepsek", width:"150", title:"NIP Kepsek"},
                    {field:"nama_bendahara", width:"150", title:"Nama Bendaha"},
                    {field:"nip_bendahara", width:"150", title:"NIP Bendahara"},
                    // {field:'npsn',width:'100',title:'NPSN'},
                    // {field:'sekolah',title:'Sekolah',width:'250',formatter:function(value,row){return row.sekolah.nama_sekolah}},
                    // {field:'saldo', width:'200',title:'Pencairan', formatter:function(value, row){ return cetakIDR(value) }},
                    // {field:'sisa', width:'180',title:'Sisa Saldo', formatter:function(value, row){ return cetakIDR(row.sisa.saldo) }}
                ]]
            });

            
        });
        function doSearch(){
            $('#dg').datagrid('load',{
                npsn: $('#snpsn').val(),
                namasekolah: $('#ssekolah').val(),
                kecamatan: $('#skecamatan').val(),
            });
        }
        function newSekolah(){
            $('#dlg').dialog('open').dialog('setTitle','Tambah Sekolah');
            $('#fm').form('clear');
            url = 'config/sekolah/save.php';
        }
        function editSekolah(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','Edit Sekolah');
                $('#fm').form('load',row);
                
                url = 'config/sekolah/update.php?id='+row.id_sekolah;
            }
        }
        function editPassword(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlgpw').dialog('open').dialog('setTitle','Edit Password');
                // $('#fmpw').form('load',row);
                
                url = 'config/sekolah/ubah_password.php?id='+row.id_sekolah;
            }
        }
        function saveSekolah(){
            $('#fm').form('submit',{
                url: url,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        $.messager.alert('Error',result.errorMsg,'error');
                    } else {
                        $('#dlg').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the user data
                    }
                }
            });
        }
        function resetPassword(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Apakah anda akan mereset Password '+row.nama_sekolah+'?',function(r){
                    if (r){
                        $.post('config/sekolah/reset_password.php',{id:row.id_sekolah},function(result){
                            if (result.success){
                                $('#dg').datagrid('reload');    // reload the user data
                            } else {
                                $.messager.alert('Error',result.errorMsg,'error');
                            }
                        },'json');
                    }
                });
            }
        }
        function savePassword(){
            if ($('#fppasswordbaru').textbox('getValue')==$('#fppasswordkonfirmasi').textbox('getValue')) {
                if ($('#fppasswordlama').textbox('getValue') != '' && $('#fppasswordbaru').textbox('getValue') != '') {
                    $('#fmpw').form('submit',{
                        url: url,
                        onSubmit: function(){
                            return $(this).form('validate');
                        },
                        success: function(result){
                            var result = eval('('+result+')');
                            if (result.errorMsg){
                                $.messager.alert('Error',result.errorMsg,'error');
                            } else {
                                $('#dlgpw').dialog('close');        // close the dialog
                                $('#dg').datagrid('reload');    // reload the user data
                            }
                        }
                    });
                }
                else{
                    $("#spanvalidasi").text("Mohon lengkapi form terlebih dahulu").show().fadeOut( 3000 );    
                }
            }
            else{
                $("#spanvalidasi").text("Mohon cocokkan kembali konfirmasi password baru anda").show().fadeOut( 3000 );
            }
        }
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
