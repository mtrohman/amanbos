<?php
    use App\Models\Pagu;

    include_once '../db.php';
    // include_once '../../ceklogin.php';
    require_once '../dbmanager.php';

    $ta= $_SESSION['ta'];
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
	
// 'npsn', 'like', '%' .$npsn. '%'
	$pagu = Pagu::ta($ta)->npsn($npsn)->namaSekolah($sekolah)->with('sekolah')->skip($offset)->take($rows)->get();
    $pagucount= Pagu::ta($ta)->npsn($npsn)->namaSekolah($sekolah)->count();
	$result = array();
	$result["total"] = $pagucount;
	$result["rows"] = $pagu;
	
	echo json_encode($result);
?>