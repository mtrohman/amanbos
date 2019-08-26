<?php
include_once 'config/db.php';
include_once 'ceklogin.php';
require_once 'config/dbmanager.php';
use App\Models\Sekolah;
use App\Models\Pagu;
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
    <title>Data RKA - <?php echo $namaweb;?></title>
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
                    <h3 class="text-themecolor">Data RKA Sekolah</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">RKA</li>
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
                <?php
                    if($_SESSION['role']==2){
                        $npsn= $_SESSION['username'];
                        $sekolah= Sekolah::npsn($npsn)->first();
                        $sisapagu1= $sekolah->pagus()->ta($ta)->with('sisa')->get()->sum('sisa.tw1');
                        // echo json_encode($sisapagu1);
                        // ->sum('sisa.tw1');
                        $sisapagu2= $sekolah->pagus()->ta($ta)->with('sisa')->get()->sum('sisa.tw2');
                        // echo json_encode($sisapagu2);
                        // ->sum('sisa.tw2');
                        $sisapagu3= $sekolah->pagus()->ta($ta)->with('sisa')->get()->sum('sisa.tw3');
                        // echo json_encode($sisapagu3);
                        // ->sum('sisa.tw3');
                        $sisapagu4= $sekolah->pagus()->ta($ta)->with('sisa')->get()->sum('sisa.tw4');
                        // echo json_encode($sisapagu4);
                        // ->sum('sisa.tw4');
                ?>
                    <!-- row -->
                    <div class="row">
                        <!-- Column -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="d-flex flex-row">
                                    <div class="p-10 bg-info">
                                        <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                    <div class="align-self-center m-l-20">
                                        <h5 class="m-b-0 text-info"><?=rupiah($sisapagu1);?></h5>
                                        <h6 class="text-muted m-b-0">Pagu Triwulan 1</h6></div>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <!-- Column -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="d-flex flex-row">
                                    <div class="p-10 bg-warning">
                                        <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                    <div class="align-self-center m-l-20">
                                        <h5 class="m-b-0 text-warning"><?=rupiah($sisapagu2);?></h5>
                                        <h6 class="text-muted m-b-0">Pagu Triwulan 2</h6></div>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <!-- Column -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="d-flex flex-row">
                                    <div class="p-10 bg-primary">
                                        <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                    <div class="align-self-center m-l-20">
                                        <h5 class="m-b-0 text-primary"><?=rupiah($sisapagu3);?></h5>
                                        <h6 class="text-muted m-b-0">Pagu Triwulan 3</h6></div>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <!-- Column -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="d-flex flex-row">
                                    <div class="p-10 bg-danger">
                                        <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                    <div class="align-self-center m-l-20">
                                        <h5 class="m-b-0 text-danger"><?=rupiah($sisapagu4);?></h5>
                                        <h6 class="text-muted m-b-0">Pagu Triwulan 4</h6></div>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                    <!-- /row -->
                <?php }?>
                <div class="row justify-content-md-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="text-center text-md-left db">
                                            <img src="assets/images/semarangkab.png" class="logospecial">
                                            <h1 class="h1special pull-right d-none d-md-block">RKA</h1>
                                        </div> 
                                    </div>
                                </div>
                                <hr>
                                

                                <div class="table-responsive">
                                    <table id="dg" title="" class="easyui-datagrid" style="width:100%;height:400px" toolbar="#toolbar" pagination="true"
                                        rownumbers="true" fitColumns="false" singleSelect="true">
                                        
                                    </table>
                                    <div id="toolbar">
                                    <?php
                                    if ($role==2) {
                                        ?>
                                        <div>
                                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newRka()">Tambah</a>
                                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editRka()">Edit</a>
                                            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyRka()">Hapus</a>
                                        
                                        </div>
                                        <?php
                                    }
                                    ?>
                                        <div>
                                            <!-- <span>npsn:</span>
                                            <input id="npsn" style="line-height:26px;border:1px solid #ccc"> -->
                                            <span>triwulan:</span>
                                            <input id="triwulan" style="line-height:26px;border:1px solid #ccc">
                                            <a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Search</a>
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>
                        </div>

                        <div class="collapse" id="inputrka">
                            <div class="card card-body">
                                <div class="table-responsive">
                                    <h3 class="card-title" id="judulForm">Tambah RKA</h3>
                                    <hr>

                                    <div class="form-group row p-0 m-0" style="min-height:0.5rem">
                                        <label class="control-label text-right col-md-3">NPSN</label>
                                        <div class="col-md-9">
                                            <input id="npsn" type="text" name="npsn" class="form-control p-0" style="min-height:0.5rem" form="forminput" >
                                        </div>
                                    </div>
                                    <div class="form-group row p-0 m-0" style="min-height:0.5rem">
                                        <label class="control-label text-right col-md-3">TA</label>
                                        <div class="col-md-9">
                                            <input id="ta" type="text" name="ta" class="form-control p-0" style="min-height:0.5rem" form="forminput" >
                                        </div>
                                    </div>
                                    <div class="form-group row p-0 m-0" style="min-height:0.5rem">
                                        <label class="control-label text-right col-md-3">Triwulan</label>
                                        <div class="col-md-9">
                                            <input id="tw" type="text" name="triwulan" class="form-control p-0" style="min-height:0.5rem" form="forminput" >
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="alert alert-danger" id="spanvalidasi" style="display: none">
                                    </div>
                                    <button class="btn btn-sm btn-info m-b-5" id="addRow" >Add</button>
                                    
                                    <form class="form" method="POST" id="forminput">
                                        <table style="width:1200px" class="table table-sm color-table info-table" id="tableInput">
                                            <!-- <caption style="caption-side:top" ><b>Tambah RKA</b></caption> -->
                                            <thead>
                                                <tr>
                                                    <!-- <th width="100">NPSN</th> -->
                                                    <!-- <th width="70">TA</th> -->
                                                    <th width="250">Uraian</th>
                                                    <th width="450" colspan="2">Program</th>
                                                    <th width="450" colspan="2">KP</th>
                                                    <th width="450" colspan="2">Rekening</th>
                                                    <th width="150">Nilai</th>
                                                    <th width="80">Hapus</th>
                                                </tr>
                                                <tr id="template" style="display: none">
                                                    <!-- <td>
                                                        <input id="npsn" type="text" class="form-control p-0" style="min-height:0.5rem"  required="" />
                                                    </td>
                                                    <td>
                                                        <input id="ta" type="text" class="form-control p-0" style="min-height:0.5rem"  required="" />
                                                    </td> -->
                                                    <td>
                                                        <input id="uraian" type="text" name="uraian[]" class="form-control p-0" style="min-height:0.5rem"  required="" />
                                                    </td>
                                                    <td> 
                                                        <input class="form-control p-0" style="min-height:0.5rem" name="program[]" type="text" id="namaprogram" readonly="">
                                                        <input id="idprogram" name="idprogram[]" type="text" hidden="">
                                                        <!-- <input id="program" type="text" class="form-control p-0" style="min-height:0.5rem" name="program[]" /> -->
                                                    </td>
                                                    <td>
                                                        <button id="btnprogram" class="btn btn-info p-t-0 p-b-0" type="button" >...</button>
                                                    </td>

                                                    <td>
                                                        <input class="form-control p-0" style="min-height:0.5rem" name="kp[]" type="text" id="namakomponen" readonly="">
                                                        <input id="idkomponen" name="idkp[]" type="text" hidden="">
                                                        <!-- <input id="kp" type="text" class="form-control p-0" style="min-height:0.5rem" name="kp[]" /> -->
                                                    </td>
                                                    <td>
                                                        <button id="btnkp" class="btn btn-warning p-t-0 p-b-0" type="button" >...</button>
                                                    </td>
                                                    
                                                    <td>
                                                        <input class="form-control p-0" style="min-height:0.5rem" name="rekening[]" type="text" id="namarekening" readonly="">
                                                        <input id="idrekening" name="idrekening[]" type="text" hidden="">
                                                        <!-- <input id="rekening" type="text" class="form-control p-0" style="min-height:0.5rem" name="rekening[]" /> -->
                                                    </td>
                                                    <td>
                                                        <button id="btnrekening" class="btn btn-primary p-t-0 p-b-0" type="button" >...</button>
                                                    </td>
                                                    
                                                    <td>
                                                        <input id="nilai" type="text" class="form-control p-0 nilai" style="min-height:0.5rem" name="nilai[]" required="" />
                                                    </td>
                                                    
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger btn-hapus">Hapus</button>
                                                    </td>

                                                </tr>
                                                
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr style="background-color: #1976d2; color: #ffffff;">
                                                    <!-- <th></th> -->
                                                    <th>Total Baris <input id="totalBaris" type="text" name="totalbaris" class="p-0 ml-3"
                                                        style="min-height:0.5rem;font-size: 1rem;
                                                        line-height: 1.5;
                                                        color: #495057;
                                                        background-clip: padding-box;
                                                        border: 1px solid #ced4da;
                                                        border-radius: .25rem;
                                                        text-align: center;
                                                        width: 30px;background-color: #e9ecef;" readonly>
                                                    </th>
                                                    <th colspan="6" class="text-right">Total Nilai</th>
                                                    <th><input id="totalNilai" name="totalnilai" type="text" class="form-control p-0" style="min-height:0.5rem" readonly=""></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <button class="btn btn-sm btn-danger" type="button" onclick="cancelInput()">Cancel</button>
                                        <button class="btn btn-sm btn-success" type="button" onclick="saveRka()">Save</button>
                                    </form>
                                    
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
        var npsn="<?=($_SESSION['role']==2) ? $_SESSION['username'] : '';?>";
        $('#dg').datagrid({
            url:'config/rka/getdata.php?npsn='+npsn ,
            emptyMsg:'Tidak ada data tersedia',
            columns: [[
                {field:'ta',title:'TA'},
                {field:'triwulan',title:'Triwulan'},
                {field:'npsn',width:'100',title:'NPSN'},
                {
                    field:'sekolah',title:'Sekolah',width:'250',
                    formatter:function(value,row){
                        return row.sekolah.nama_sekolah;
                    }
                },
                {field:'uraian',title:'Uraian'},
                {
                    field:'program',title:'Program',width:'250',
                    formatter:function(value,row){
                        if(value){
                            return row.program.nama_program;
                        }
                    }
                },
                {
                    field:'kp',title:'KP',width:'250',
                    formatter:function(value,row){
                        if(value){
                            return row.kp.nama_pembiayaan;
                        }
                    }
                },
                {field:'nama_rekening',width:'250',title:'Rekening'},
                {
                    field:'nilai',width:'250',title:'Nilai',
                    formatter:function(value, row){ 
                        if(value){
                            return cetakIDR(value);
                        }
                    }
                }
                
            ]]
        });

        function doSearch(){
			$('#dg').datagrid('load',{
				triwulan: $('#triwulan').val()
			});
		}

        function cariProgram(val) {
            // console.log(val);
            $('#modalprogram').modal('show');
            $('.pilihprogram').attr('id',('pilihprogram'+val));
            $('#modalprogram').on('click',('#pilihprogram'+val), function(){
                $('#namaprogram'+val).val($(this).attr('data-namaprogram'));
                $('#idprogram'+val).val($(this).attr('data-idprogram'));
                $('#modalprogram').modal('hide');
            });
        }

        function cariKp(val) {
            // console.log(val);
            $('#modalkomponen').modal('show');
            $('.pilihkomponen').attr('id',('pilihkomponen'+val));
            $('#modalkomponen').on('click',('#pilihkomponen'+val), function(){
                $('#namakomponen'+val).val($(this).attr('data-namakomponen'));
                $('#idkomponen'+val).val($(this).attr('data-idkomponen'));
                $('#modalkomponen').modal('hide');
            });
        }

        function cariRekening(val) {
            // console.log(val);
            $('#modalrekening').modal('show');
            // $('.pilihrekening').attr('id',('pilihrekening'+val));
            $("#lookuprekening").DataTable().rows().nodes().to$().attr('id',('pilihrekening'+val));
            $('#modalrekening').on('click',('#pilihrekening'+val), function(){
                $('#namarekening'+val).val($(this).attr('data-namarekening'));
                $('#idrekening'+val).val($(this).attr('data-idrekening'));
                $('#modalrekening').modal('hide');
            });
        }


        var row = 1;
        function tambahBaris() {
            // e.preventDefault();
            var template = $('#template')
            .clone()                        // CLONE THE TEMPLATE
            .attr('id', 'row' + row)    // MAKE THE ID UNIQUE
            .appendTo($('#tableInput tbody'))  // APPEND TO THE TABLE
            .show();                        // SHOW IT
            template.children().each( function () {
                // var title = $(this).children().prop('id');
                // $(this).children().attr('id', title + (row));
                $(this).children().each(function(){
                    var title = $(this).prop('id');
                    $(this).attr('id', title + (row));
                });
            });
            updateNilai();
            $('#btnprogram'+row).attr('onClick', 'cariProgram('+row+')');
            $('#btnkp'+row).attr('onClick', 'cariKp('+row+')');
            $('#btnrekening'+row).attr('onClick', 'cariRekening('+row+')');
            row++;
        }


        

        function updateNilai(){
            var TotalNilai = 0;
            $('#tableInput').find('tbody').find('tr').each(function(){
                var nilai= parseFloat($(this).find('.nilai').val());
                if(!isNaN(nilai)){
                    TotalNilai+= nilai;
                }
            });
            // alert(TotalNilai);
            $('#totalNilai').val(TotalNilai);
            $('#totalBaris').val($('tr', $('#tableInput').find('tbody')).length);
            
        }

        $('#tableInput').on('change', '.nilai', function () {
            updateNilai();
        });

        var url;
		function newRka(){
            $('#inputrka').collapse('show');
            $('#addRow').show();
            $('#judulForm').text("Tambah RKA");
            // 
            $('html, body').animate(
                {
                  scrollTop: $('#inputrka').offset().top,
                },
                500,
                'linear'
              )
            //
            $('#tw').val('').removeAttr('readonly');
            $('#tableInput').find('tbody').detach();
            $('#tableInput').append($('<tbody>'));  
            $('#forminput').form('clear');
            $('#npsn').val("<?=$_SESSION['username'];?>").attr('readonly','true');
            $('#ta').val("<?=$_SESSION['ta'];?>").attr('readonly','true');
            $('#forminput').attr('action','config/rka/save.php');
            row = 1;
            tambahBaris();
			// $('#dlg').dialog('open').dialog('setTitle','New User');
			// url = 'save.php';
		}


        function saveRka() {
            var empty = true;
            var twempty = true;

            $('#tableInput').find('tbody').find('tr').each(function(){
                $(this).children().each(function(){        
                    if($(this).find('input').val()!=""){
                        empty =false;
                      // return false;
                    }
                    else{
                        empty=true;
                        return false;
                    }
                    // alert(empty+" :"+$(this).find('input').val());
                });
            });

            if($('#tw').val()!=""){
                twempty=false;
            }
            else{
                twempty=true;
            }
            // alert($("#tw").val());

            if (!empty && !twempty) {
                $("#template").detach();
                $( "#forminput" ).submit();
            }
            else{
                $("#spanvalidasi").text("Mohon lengkapi formulir anda terlebih dahulu").show().fadeOut( 3000 );
            }

            
        }

        $('#addRow').click(function() {
            tambahBaris();
        });

        $('#tableInput').on('click', '.btn-hapus', function () {
            $(this).parent().parent().fadeOut("slow", function () {
                $(this).remove();
                updateNilai();
            });
        });
        
        function cancelInput(){
			$('#inputrka').collapse('hide');
            $('#tableInput').find('tbody').detach();
            $('#tableInput').append($('<tbody>'));  
            $('#forminput').form('clear');
		}

        function editRka() {
            // body...
            var data = $('#dg').datagrid('getSelected');
            console.log(data);
            if (data){
                $('#inputrka').collapse('show');
                $('#addRow').hide();
                $('#judulForm').text("Edit RKA");
                // 
                $('html, body').animate(
                    {
                      scrollTop: $('#inputrka').offset().top,
                    },
                    500,
                    'linear'
                  )
                //
                $('#tableInput').find('tbody').detach();
                $('#tableInput').append($('<tbody>'));  
                $('#forminput').form('clear');

                $('#npsn').val(data.npsn).attr('readonly','true');
                $('#ta').val(data.ta).attr('readonly','true');
                $('#tw').val(data.triwulan).attr('readonly','true');

                $('#forminput').attr('action','config/rka/update.php?id='+data.id);
                row = 1;
                tambahBaris();
                
                $('#uraian1').val(data.uraian);

                $('#namaprogram1').val(data.program.nama_program);
                $('#idprogram1').val(data.program.id);
                
                $('#namakomponen1').val(data.kp.nama_pembiayaan);
                $('#idkomponen1').val(data.kp.id);

                $('#namarekening1').val(data.nama_rekening);
                $('#idrekening1').val(data.rekening_id);

                $('#nilai1').val(data.nilai);
                updateNilai();
            }
        }

        function destroyRka(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Apakah anda akan menghapus data rka '+row.sekolah.nama_sekolah+' dengan rekening: '+row.nama_rekening+'?',function(r){
                    if (r){
                        $.post('config/rka/destroy.php',{id:row.id},function(result){
                            if (result.success){
                                $('#dg').datagrid('reload');    // reload the user data
                            } else {
                                $.messager.show({   // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
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
