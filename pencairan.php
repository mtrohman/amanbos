<?php
include_once 'config/db.php';
include_once 'ceklogin.php';
require_once 'config/dbmanager.php';
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
    <title>Data Pencairan - <?php echo $namaweb;?></title>
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
    <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/material-teal/easyui.css">
    <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/color.css">
    <!-- <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css"> -->
    
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
        .datagrid-header td,
        .datagrid-body td {
          border-color: #ebebeb;
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
                    <h3 class="text-themecolor">Data Pencairan Sekolah</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Pencairan</li>
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
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="text-center text-md-left db">
                                            <img src="assets/images/semarangkab.png" class="logospecial">
                                            <h1 class="h1special pull-right d-none d-md-block">Pencairan</h1>
                                        </div> 
                                    </div>
                                </div>
                                <hr>
                                

                                <div class="table-responsive">
                                    <table id="dg" title="" class="easyui-datagrid" style="width:100%;height:400px"
                                        pagination="true"
                                        rownumbers="true" fitColumns="false" singleSelect="true"
                                        <?=($_SESSION['role']==1) ? 'toolbar="#toolbar"' : '';?>>
                                        
                                    </table>
                                    <div id="toolbar" style="display: none">
                                        <div>
                                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newPencairan()">Tambah</a>
                                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-upload" plain="true" onclick="uploadPencairan()">Upload</a>
                                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editPencairan()">Edit</a>
                                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyPencairan()">Hapus</a>
                                            <!-- icon-mini-add -->
                                            
                                        </div>
                                        <div>
                                            <span>npsn:</span>
                                            <input id="npsn" style="line-height:26px;border:1px solid #ccc">
                                            <span>sekolah:</span>
                                            <input id="sekolah" style="line-height:26px;border:1px solid #ccc">
                                            <a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Cari</a>
                                        </div>
                                    </div>

                                    <div id="dlg" class="easyui-dialog" style="width:400px;max-width:80%;padding:10px 20px;" closed="true" buttons="#dlg-buttons">
                                        <!-- <div class="ftitle">User Information</div> -->
                                        <form id="fm" method="post">
                                            <!-- <div class="fitem">
                                                <label>First Name:</label>
                                                <input name="firstname" required="true">
                                            </div> -->
                                            <div class="fitem" style="margin-bottom:10px">
                                                <input name="ta" label="TA" id="fta" class="easyui-textbox" labelWidth="150" style="width:100%">
                                            </div>
                                            <div class="fitem" style="margin-bottom:10px">
                                                <input name="triwulan" label="Triwulan" id="ftriwulan" class="easyui-textbox" labelWidth="150" style="width:100%">
                                            </div>
                                            <div style="margin-bottom:10px">
                                                <input name="npsn" id="cg" label="Sekolah" labelWidth="150" style="width:100%">
                                            </div>
                                            <!-- <div class="fitem" style="margin-bottom:10px">
                                                <input name="npsn" label="npsn" id="fnpsn" class="easyui-textbox" labelWidth="150" style="width:100%">
                                            </div> -->
                                            <div class="fitem" style="margin-bottom:10px">
                                                <input name="saldo" label="Pencairan" id="fpencairan" class="easyui-numberbox" labelWidth="150" style="width:100%" data-options="min:0,precision:2,decimalSeparator:',',groupSeparator:'.',prefix:'Rp '">
                                            </div>
                                            <div style="margin-bottom:10px">
                                                <input name="tanggal_pencairan" label="Tanggal" id="tgl" type="text" class="easyui-datebox" labelWidth="150" style="width:100%" data-options="formatter:myformatter,parser:myparser">
                                            </div>

                                            
                                        </form>
                                    </div>

                                    <div id="dlg-buttons">
                                        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="savePencairan()" style="width:90px">Save</a>
                                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
                                    </div>

                                    <div id="dlgupload" class="easyui-dialog" style="width:400px;max-width:80%;padding:10px 20px;" closed="true" buttons="#dialogbuttonupload">
                                        <!-- <div class="ftitle">User Information</div> -->
                                        <form id="fmupload" method="post" enctype="multipart/form-data">
                                            <!-- <div class="fitem">
                                                <label>First Name:</label>
                                                <input name="firstname" required="true">
                                            </div> -->
                                            <div class="fitem" style="margin-bottom:10px">
                                                <input name="ta" label="TA" id="futa" class="easyui-textbox" labelWidth="150" style="width:100%">
                                            </div>
                                            <div class="fitem" style="margin-bottom:10px">
                                                <input name="triwulan" label="Triwulan" id="futriwulan" class="easyui-textbox" labelWidth="150" style="width:100%">
                                            </div>
                                            <input class="easyui-filebox" name="file" labelWidth="150" label="File" id="fufile"  data-options="prompt:'Xlsx File...'" style="width:100%">
                                            
                                        </form>
                                    </div>
                                    
                                    <div id="dialogbuttonupload">
                                        <a href="format/formatpencairan.xlsx" class="easyui-linkbutton pull-left" iconCls="icon-help" style="width:120px">Sample xlsx</a>

                                        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="doUploadPencairan()" style="width:90px">Upload</a>
                                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgupload').dialog('close')" style="width:90px">Cancel</a>
                                    </div>

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
    <!-- <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script> -->
	<script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="http://www.jeasyui.com/easyui/plugins/jquery.datagrid.js"></script>
    <script src="assets/js/fungsi.js"></script>
    <script>
        function myformatter(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y;
        }

        function myparser(s){
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[2],10);
            var m = parseInt(ss[1],10);
            var d = parseInt(ss[0],10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                return new Date(y,m-1,d);
            } else {
                return new Date();
            }
        }

        function sqldateparser(s){
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[0],10);
            var m = parseInt(ss[1],10);
            var d = parseInt(ss[2],10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                return new Date(y,m-1,d);
            } else {
                return new Date();
            }
        }
        var npsn="<?=($_SESSION['role']==2) ? $_SESSION['username'] : '';?>";
        $('#dg').datagrid({
            url:'config/pencairan/getdata.php?npsn='+npsn,
            emptyMsg:'Tidak ada data tersedia',
            columns: [[
                {
                    field:'tanggal_pencairan',title:'Tanggal',align:'center',
                    formatter:function(value, row){
                        if(value){
                            return myformatter(sqldateparser(value));
                        }
                        else{
                            return "-";
                        }
                    }
                },
                {field:'ta',title:'TA'},
                {field:'triwulan',title:'Triwulan',align:'center'},
                {field:'npsn',width:'100',title:'NPSN'},
                {field:'sekolah',title:'Sekolah',width:'250',formatter:function(value,row){return row.sekolah.nama_sekolah; }},
                {field:'saldo', width:'200',title:'Pencairan', formatter:function(value, row){ return cetakIDR(value); }},
                // {field:'sisa', width:'180',title:'Sisa Saldo', formatter:function(value, row){ return cetakIDR(row.sisa.saldo) }}
            ]]
        });

        $('#cg').combogrid({
            panelWidth:500,
            // delay: 250,
            url: 'config/sekolah/combogrid.php',
            idField:'npsn',
            textField:'nama_sekolah',
            mode:'remote',
            fitColumns:false,
            columns: [[
                {field:"npsn", width:"100",title:"NPSN"},
                {field:"nama_sekolah",width:"200",title:"Nama Sekolah"},
                {field:"jenjang", width:"80", title:"Jenjang"},
                {field:"status", width:"80", title:"Status"},
                {field:"kecamatan", width:"150", title:"Kecamatan",formatter:function(value,row){return row.kecamatannya.nama_kecamatan;}},
                {field:"alamat", width:"200", title:"Alamat"},
                {field:"telepon", width:"150", title:"Telepon"},
                
            ]]
        });

        var url;
		function newPencairan(){
			$('#dlg').dialog('open').dialog('setTitle','Tambah Pencairan');
			$('#fm').form('clear');
            $('#fta').textbox('readonly');
            $('#fta').textbox('setValue','<?=$_SESSION["ta"];?>');
            $('#ftriwulan').textbox('readonly',false);
            $('#cg').combogrid('readonly',false);

			url = 'config/pencairan/save.php';
		}

        function savePencairan(){
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

        var urlupload;
        function uploadPencairan(){
            $('#dlgupload').dialog('open').dialog('setTitle','Upload Pencairan');
            $('#fmupload').form('clear');
            $('#futa').textbox('readonly');
            $('#futa').textbox('setValue','<?=$_SESSION["ta"];?>');
            urlupload = 'config/pencairan/upload.php';
        }

        function doUploadPencairan(){
            $('#fmupload').form('submit',{
                url: urlupload,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success:function(result){
                    var resultupload= JSON.parse(result);
                    if (resultupload.errorMsg){
                        $.messager.alert('Error', resultupload.errorMsg, 'error');
                    }
                    else{
                        $('#dlgupload').dialog('close');        // close the dialog
                        $.messager.alert('Info', resultupload.pesan, 'info');
                        $('#dg').datagrid('reload');    // reload the user data
                    }
                    // $.messager.alert('Info', data, 'info');
                }
            });
        }

        function editPencairan(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Edit Pencairan');
				$('#fm').form('load',{
                    // rka_id: row.rka_id,
                    // nama: row.nama,
                    ta: row.ta,
                    tanggal_pencairan: myformatter(sqldateparser(row.tanggal_pencairan))
                });
                $('#fta').textbox('readonly');
                $('#ftriwulan').textbox('readonly');
                $('#cg').combogrid('readonly');
				url = 'config/pencairan/update.php?id='+row.id;
			}
		}

        function destroyPencairan(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirm','Apakah anda akan menghapus Pencairan '+row.sekolah.nama_sekolah+'?',function(r){
					if (r){
						$.post('config/pencairan/destroy.php',{id:row.id},function(result){
							if (result.success){
								$('#dg').datagrid('reload');	// reload the user data
							} else {
                                $.messager.alert('Error',result.errorMsg,'error');
							}
						},'json');
					}
				});
			}
		}

        function doSearch(){
			$('#dg').datagrid('load',{
				npsn: $('#npsn').val(),
				sekolah: $('#sekolah').val()
			});
		}

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
