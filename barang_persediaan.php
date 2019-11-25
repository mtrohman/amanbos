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
    <title>Data Barang Persediaan - <?php echo $namaweb;?></title>
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
                    <h3 class="text-themecolor">Data Barang Persediaan</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Barang Persediaan</li>
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
                                            <h1 class="h1special pull-right d-none d-md-block">Barang Persediaan</h1>
                                        </div> 
                                    </div>
                                </div>
                                <hr>
                                

                                <div class="table-responsive">
                                    <table id="dg" title="" class="easyui-datagrid" style="width:100%;height:400px" pagination="true"
                                        rownumbers="true" fitColumns="false" singleSelect="true"
                                        <?=($_SESSION['role']!=0) ? 'toolbar="#toolbar"' : '';?>
                                        >
                                        
                                    </table>
                                    <div id="toolbar" style="display: none">
                                        <div>
                                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newBarangPersediaan()">Tambah</a>
                                            <!-- <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-upload" plain="true" onclick="uploadPagu()">Upload</a> -->
                                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editBarangPersediaan()">Edit</a>
                                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyBarangPersediaan()">Hapus</a>
                                            
                                        </div>
                                        <div>
                                            <span>npsn:</span>
                                            <input id="npsn" style="line-height:26px;border:1px solid #ccc">
                                            <span>sekolah:</span>
                                            <input id="sekolah" style="line-height:26px;border:1px solid #ccc">
                                            <a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Cari</a>
                                        </div>
                                    </div>

                                    <div id="dlg" class="easyui-dialog" style="width:500px;max-width:80%;padding:10px 20px;" closed="true" buttons="#dlg-buttons">
                                        <!-- <div class="ftitle">User Information</div> -->
                                        <form id="fm" method="post">
                                            <div style="margin-bottom:10px">
                                                <input name="npsn" label="NPSN" id="fnpsn" class="easyui-textbox" labelWidth="150" style="width:100%">
                                            </div>
                                            <div style="margin-bottom:10px">
                                                <input name="nama_persediaan" label="Nama Persediaan" id="fnama_persediaan" class="easyui-textbox" labelWidth="150" style="width:100%">
                                            </div>
                                            <div style="margin-bottom:10px">
                                                <input name="satuan" label="Satuan" id="fsatuan" class="easyui-textbox" labelWidth="150" style="width:100%">
                                            </div>
                                            <div style="margin-bottom:10px">
                                                <input name="harga_satuan" label="Harga Satuan" id="fharga_satuan" class="easyui-numberbox" labelWidth="150" style="width:100%" data-options="min:0,precision:2,decimalSeparator:',',groupSeparator:'.',prefix:'Rp '">
                                            </div>
                                            
                                        </form>
                                    </div>
                                    <div id="dlg-buttons">
                                        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveBarangPersediaan()" style="width:90px">Save</a>
                                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
                                    </div>

                                    <!-- <div id="dlgupload" class="easyui-dialog" style="width:500px;max-width:80%;padding:10px 20px;" closed="true" buttons="#dialogbuttonupload">
                                        <div class="ftitle">User Information</div>
                                        <form id="fmupload" method="post" enctype="multipart/form-data">
                                            <div class="fitem">
                                                <label>First Name:</label>
                                                <input name="firstname" required="true">
                                            </div>
                                            <div class="fitem" style="margin-bottom:10px">
                                                <input name="ta" label="TA" id="fta" class="easyui-textbox" labelWidth="150" style="width:100%">
                                            </div>
                                            <div class="fitem" style="margin-bottom:10px">
                                                <input name="file" class="easyui-filebox" labelWidth="150" label="File" id="ffile" data-options="prompt:'Xlsx File...'" style="width:100%">
                                            </div>
                                                                                        
                                        </form>
                                    </div>
                                    
                                    <div id="dialogbuttonupload">
                                        <a href="format/formatpagu.xlsx" class="easyui-linkbutton pull-left" iconCls="icon-help" style="width:120px">Sample xlsx</a>
                                    
                                        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="doUploadPagu()" style="width:90px">Upload</a>
                                        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgupload').dialog('close')" style="width:90px">Cancel</a>
                                    </div> -->

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
    <?php
 // ;
    ?>
    <script>
        var npsn="<?=($_SESSION['role']==2) ? $_SESSION['username'] : '';?>";
        $('#dg').datagrid({
            url:"config/barangpersediaan/getdata.php?npsn="+npsn,
            emptyMsg:'Tidak ada data tersedia',
            columns: [[
                {field:'npsn',width:'100',title:'NPSN'},
                {field:'sekolah',title:'Sekolah',width:'250',formatter:function(value,row){return row.sekolah.nama_sekolah}},
                {field:'nama_persediaan',width:'200',title:'nama_persediaan'},
                {field:'satuan',width:'80',title:'satuan'},
                {field:'harga_satuan',width:'120',title:'harga_satuan', align: 'right'},
                {field:'stok',width:'100',title:'stok',align: 'right'},
                {field:'updated_at',width:'150',title:'Last Update'},
            ]]
        });

        var url;
		function newBarangPersediaan(){
			$('#dlg').dialog('open').dialog('setTitle','Tambah Barang Persediaan');
			$('#fm').form('clear');
            $('#fnpsn').textbox('setValue','<?=$_SESSION["username"];?>');
            $('#fnpsn').textbox('readonly',true);  // enable readonly mode
			url = 'config/barangpersediaan/save.php';
		}

        /*var urlupload;
        function uploadPagu(){
            $('#dlgupload').dialog('open').dialog('setTitle','Upload Barang Persediaan');
            $('#fmupload').form('clear');

            $('#fta').textbox('setValue','<?=$_SESSION["ta"];?>');
            $('#fta').textbox('readonly',true);  // enable readonly mode
            urlupload = 'config/pagu/upload.php';
        }

        function doUploadPagu(){
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
        }*/

        function saveBarangPersediaan(){
            $('#fm').form('submit',{
                url: url,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlg').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the user data
                    }
                }
            });
        }

        function editBarangPersediaan(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$('#dlg').dialog('open').dialog('setTitle','Edit Barang Persediaan');
				$('#fm').form('load',row);
				url = 'config/barangpersediaan/update.php?id='+row.id;
			}
		}

        function destroyPagu(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirm','Apakah anda yakin akan menghapus Barang Persediaan '+row.sekolah.nama_sekolah+'?',function(r){
					if (r){
						$.post('config/pagu/destroy.php',{id:row.id},function(result){
							if (result.success){
								$('#dg').datagrid('reload');	// reload the user data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.errorMsg
								});
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
