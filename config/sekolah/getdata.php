<?php
    use App\Models\Sekolah;

    include_once '../db.php';
    require_once '../dbmanager.php';

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
    $offset = ($page-1)*$rows;
    $namasekolah="";

    if (isset($_POST['npsn'])) {
    	$npsn=$_POST['npsn'];
    }
    else if(isset($_GET['npsn'])){
    	$npsn=$_GET['npsn'];
    }
    else{
    	$npsn='';
    }

    if (isset($_POST['namasekolah'])) {
        $namasekolah=$_POST['namasekolah'];
    }

    if (!empty($_POST['kecamatan'])) {
        $sekolah= Sekolah::with(['kecamatannya'])->npsn($npsn)->namasekolah($namasekolah)->idkecamatan($_POST['kecamatan'])->skip($offset)->take($rows)->get();
        $sekolahcount= Sekolah::npsn($npsn)->namasekolah($namasekolah)->idkecamatan($_POST['kecamatan'])->count();
    }
    else{
        $sekolah= Sekolah::with(['kecamatannya'])->npsn($npsn)->namasekolah($namasekolah)->skip($offset)->take($rows)->get();
        $sekolahcount= Sekolah::npsn($npsn)->namasekolah($namasekolah)->count();
    }

	$result = array();
	$result["total"] = $sekolahcount;
	$result["rows"] = $sekolah;
	
	echo json_encode($result);
?>