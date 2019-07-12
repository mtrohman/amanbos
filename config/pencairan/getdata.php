<?php
    use App\Models\Pencairan;

    include_once '../db.php';
    // include_once '../../ceklogin.php';
    require_once '../dbmanager.php';
    header('Content-Type: application/json');

    $ta= $_SESSION['ta'];
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
    $offset = ($page-1)*$rows;
    $npsn = isset($_POST['npsn']) ? $_POST['npsn'] : '';
	$sekolah = isset($_POST['sekolah']) ? $_POST['sekolah'] : '';
	$triwulan = isset($_POST['triwulan']) ? $_POST['triwulan'] : '';
	
// 'npsn', 'like', '%' .$npsn. '%'
	$pencairan = Pencairan::ta($ta)->triwulan($triwulan)->npsn($npsn)->namaSekolah($sekolah)->with('sekolah','sisa')->skip($offset)->take($rows)->get();
    $pencairancount= Pencairan::ta($ta)->triwulan($triwulan)->npsn($npsn)->namaSekolah($sekolah)->count();
	$result = array();
	$result["total"] = $pencairancount;
	$result["rows"] = $pencairan;
	
	echo json_encode($result);
?>