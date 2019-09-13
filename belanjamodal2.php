<?php 
include_once 'config/db.php';
include_once 'ceklogin.php';
require_once 'config/dbmanager.php';
use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Belanjathlalu;

if (!empty($_GET['id'])) {
    $id=$_GET['id'];
    $belanja= Belanjathlalu::find($id);
    if(!empty($belanja)){
        if ($belanja->jenis_belanja==1) {
            $bm= $belanja->belanja_modal;
            $kr_all = array();
            $res_kr = DB::select('call koderekening_lengkap()');
            foreach ($res_kr as $key => $value) {
                $kr_all[$value->id] = $value;
            }
        }
        else{
            header("location:javascript://history.go(-1)");
        }
    }
    else{
        header("location:javascript://history.go(-1)");
    }
}
else{
    header("location:javascript://history.go(-1)");
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
    <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/material-teal/easyui.css">
    <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/color.css">
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
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered color-bordered-table success-bordered-table table-sm nowrap">
                                        <thead>
                                            <!-- <th>Tahun Anggaran</th>
                                            <th>Triwulan</th>
                                            <th>NPSN</th>
                                            <th>Nama Sekolah</th>-->
                                            <th>Tanggal Belanja</th>
                                            <th>Uraian Belanja</th>
                                            <th>Nilai</th>
                                            <th>Kode Rekening</th>
                                            <th>Nama Rekening</th>
                                            
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?=tgl_indo($belanja->tanggal_belanja);?></td>
                                                <td><?=$belanja->nama;?></td>
                                                <td align="right"><?=rupiah($belanja->nilai);?></td>
                                                <td align="center"><?=$kr_all[$belanja->rekening_id]->path;?></td>
                                                <td><?=$kr_all[$belanja->rekening_id]->nama_rekening;?></td>
                                                         
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
                        <div class="card card-outline-success">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Data Modal</h4></div>
                            <div class="card-body">
                                <table id="dg" title="" class="easyui-datagrid" style="width:100%;height:400px"
                                        url="config/belanjathlalu/modal/getdata.php?id=<?=$belanja->id;?>"
                                        toolbar="#toolbar" pagination="true"
                                        fitColumns="false" singleSelect="true">
                                        
                                </table>
                                <div id="toolbar">
                                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newBelanjaModal()">Tambah</a>
                                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editBelanjaModal()">Edit</a>
                                    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyBelanjaModal()">Hapus</a>
                                        
                                </div>
                            </div>
                        </div>
                        <div id="dlg" class="easyui-dialog" style="width:500px;max-width:80%;padding:10px 20px;" closed="true" buttons="#dlg-buttons">
                            <!-- <div class="ftitle">User Information</div> -->
                            <form id="fm" method="post">
                                
                                <div style="margin-bottom:10px">
                                    <input name="kode_barang" label="Kode Barang" id="kode_barang" class="easyui-textbox" labelWidth="150" style="width:100%">
                                </div>
                                <div style="margin-bottom:10px">
                                    <input name="nama_barang" label="Nama Barang" id="nama" class="easyui-textbox" labelWidth="150" style="width:100%">
                                </div>
                                <div style="margin-bottom:10px">
                                    <input name="merek" label="Merek" id="merek" class="easyui-textbox" labelWidth="150" style="width:100%">
                                </div>
                                <div style="margin-bottom:10px">
                                    <input name="tipe" label="Tipe" id="tipe" class="easyui-textbox" labelWidth="150" style="width:100%">
                                </div>
                                <div style="margin-bottom:10px">
                                    <input name="warna" label="Warna Barang" id="warna" class="easyui-textbox" labelWidth="150" style="width:100%">
                                </div>
                                <div style="margin-bottom:10px">
                                    <input name="bahan" label="Bahan" id="bahan" class="easyui-textbox" labelWidth="150" style="width:100%">
                                </div>

                                <div style="margin-bottom:10px">
                                    <!-- <input name="bukti_tanggal" label="Bukti Tanggal" id="bukti_tanggal" class="easyui-numberbox" labelWidth="150" style="width:100%"> -->
                                    <input name="bukti_tanggal" label="Tanggal" id="bukti_tanggal" type="text" class="easyui-datebox" labelWidth="150" style="width:100%" data-options="formatter:myformatter,parser:myparser">
                                </div>
                                <!-- <div style="margin-bottom:10px">
                                    <input name="bukti_bulan" label="Bukti Bulan" id="bukti_bulan" class="easyui-numberbox" labelWidth="150" style="width:100%">
                                </div> -->
                                <div style="margin-bottom:10px">
                                    <input name="bukti_nomor" label="Nomor Nota" id="bukti_nomor" class="easyui-textbox" labelWidth="150" style="width:100%">
                                </div>

                                <div style="margin-bottom:10px">
                                    <input name="qty" label="Qty" id="qty" class="easyui-numberbox" labelWidth="150" style="width:100%">
                                </div>
                                <div style="margin-bottom:10px">
                                    <input name="satuan" label="Satuan" id="satuan" class="easyui-textbox" labelWidth="150" style="width:100%">
                                </div>
                                <div style="margin-bottom:10px">
                                    <input name="harga_satuan" label="Harga Satuan" id="harga" class="easyui-numberbox" labelWidth="150" style="width:100%" data-options="min:0,precision:2,decimalSeparator:',',groupSeparator:'.',prefix:'Rp '">
                                </div>
                                <div style="margin-bottom:10px">
                                    <input name="total" label="Total" id="total" class="easyui-numberbox" labelWidth="150" style="width:100%" data-options="min:0,precision:2,decimalSeparator:',',groupSeparator:'.',prefix:'Rp ',readonly:'true'">
                                </div>

                                <!-- <div style="margin-bottom:10px">
                                    <input name="tanggal_belanja" label="Tanggal" id="tgl" type="text" class="easyui-datebox" labelWidth="150" style="width:100%" data-options="formatter:myformatter,parser:myparser">
                                </div> -->
                                
                                
                            </form>
                        </div>
                        <div id="dlg-buttons">
                            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveBelanjaModal()" style="width:90px">Save</a>
                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
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
    <script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="http://www.jeasyui.com/easyui/plugins/jquery.datagrid.js"></script>
    <script type="text/javascript" src="https://www.jeasyui.com/easyui/datagrid-detailview.js"></script>
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

        $(document).ready(function(){
            $('#dg').datagrid({
                rownumbers:"true",
                showFooter:true,
                columns:
                [
                    [
                        {title:'Data Barang', halign: 'center',colspan:6},
                        
                        {title: 'Bukti Pembelian', halign: 'center',colspan:2},
                        
                        {title: 'Jumlah', halign: 'center',colspan:2},
                        
                        {title: 'Harga', halign: 'center',colspan:2},

                    ],
                    [
                        
                        {field:'kode_barang',title:'kode Barang',width:200},
                        {field:'nama_barang',title:'Nama Barang',width:200},
                        {field:'merek',title:'Merek',width:100,align:'center'},
                        {field:'tipe',title:'tipe',width:100,align:'center'},
                        {field:'warna',title:'warna',width:100,align:'center'},
                        {field:'bahan',title:'bahan',width:100,align:'center'},

                        {field:'bukti_tanggal',title:'Tgl',align:'center',width:50},
                        {field:'bukti_nomor',title:'Nomor Nota',align:'center',width:180},

                        {field:'qty',title:'Qty',width:80,align:'center'},
                        {field:'satuan',title:'Satuan',width:100,align:'center'},

                        {field:'harga_satuan',title:'Harga Satuan',width:100,align:'center',formatter:function(value, row){ 
                                if (value) {
                                    return cetakIDR(value);
                                }
                            }
                        },
                        {field:'total',title:'Total',width:100,align:'center',formatter:function(value, row){ return cetakIDR(value);}},

                        // {field:'bukti',title:'Nomor Pembelian',width:200,align:'center',formatter:function(value, row){ return row.bukti_tanggal+"-"+row.bukti_bulan+"-"+row.bukti_nomor;}},

                        
                    ]
                ]
            });

            $('#qty').numberbox({
                onChange:function(newValue,oldValue) {
                    var harga = $('#harga').numberbox('getValue');
                    var total = harga*newValue;
                    $('#total').numberbox('setValue', total);
                }
            });

            $('#harga').numberbox({
                onChange:function(newValue,oldValue) {
                    var qty = $('#qty').numberbox('getValue');
                    var total = qty*newValue;
                    $('#total').numberbox('setValue', total);
                }
            });
        });

        var url;
        function newBelanjaModal(){
            $('#dlg').dialog('open').dialog('setTitle','Tambah Belanja Modal');
            $('#fm').form('clear');
            url = 'config/belanja/modal/save.php?id=<?=$id;?>';
        }
        function saveBelanjaModal(){
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
        function editBelanjaModal(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','Edit Belanja');
                $('#fm').form('load',row);
                
                url = 'config/belanja/modal/update.php?modal='+row.id;
            }
        }
        function destroyBelanjaModal(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Apakah anda yakin akan menghapus Modal '+row.nama_persediaan+'?',function(r){
                    if (r){
                        $.post('config/belanja/modal/destroy.php',{id:row.id},function(result){
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
