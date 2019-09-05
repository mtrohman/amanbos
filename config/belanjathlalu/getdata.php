<?php

use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Belanjathlalu;
use App\Models\Rka;


include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

$ta = $_SESSION['ta'];
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page - 1) * $rows;

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
$triwulan = isset($_POST['triwulan']) ? $_POST['triwulan'] : '';

$kr_all = array();
$res_kr = DB::select('call koderekening_lengkap()');
foreach ($res_kr as $key => $value) {
    $kr_all[$value->id] = $value;
}


// $jsonrka = array();
$jsonbelanja = array();

// 'npsn', 'like', '%' .$npsn. '%'
$belanja = Belanjathlalu::with(['program','kp','sekolah'])->ta($ta)->triwulan($triwulan)->npsn($npsn)->namaSekolah($sekolah)->skip($offset)->take($rows)->get();

$belanjacount = Belanjathlalu::with(['program','kp','sekolah'])->ta($ta)->triwulan($triwulan)->npsn($npsn)->namaSekolah($sekolah)->count();

foreach ($belanja as $key => $value) {
    $jsonbelanja[$key] = $value;
    $jsonbelanja[$key]['nomor_rekening'] = $kr_all[$value->rekening_id]->path;
    $jsonbelanja[$key]['nama_rekening'] = $kr_all[$value->rekening_id]->nama_rekening;
}


$result = array();
$result["total"] = $belanjacount;
$result["rows"] = $jsonbelanja;

echo json_encode($result);
