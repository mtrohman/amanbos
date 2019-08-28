<?php
    use App\Models\Saldo;

    include_once '../db.php';
    // include_once '../../ceklogin.php';
    require_once '../dbmanager.php';
    header('Content-Type: application/json');

    $ta= $_SESSION['ta'];
    if(isset($_GET['thlalu'])){
        $ta= $_SESSION['ta']-1;
    }
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
    $offset = ($page-1)*$rows;
    // $npsn = isset($_POST['npsn']) ? $_POST['npsn'] : '';
    if (isset($_POST['npsn'])) {
    	$npsn=$_POST['npsn'];
    }
    else if(isset($_GET['npsn'])){
    	$npsn=$_GET['npsn'];
    }
    else{
    	$npsn='';
    }

	$sekolah = isset($_POST['sekolah']) ? $_POST['sekolah'] : '';
	// $triwulan = isset($_POST['triwulan']) ? $_POST['triwulan'] : '';
	
// 'npsn', 'like', '%' .$npsn. '%'
	$saldo = Saldo::ta($ta)->npsn($npsn)->namaSekolah($sekolah)->with('sekolah')->skip($offset)->take($rows)->get();
    $saldocount= Saldo::ta($ta)->npsn($npsn)->namaSekolah($sekolah)->count();
	$result = array();
	$result["total"] = $saldocount;
	$result["rows"] = $saldo;
	
	echo json_encode($result);
?>