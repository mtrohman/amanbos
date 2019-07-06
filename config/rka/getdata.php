<?php

use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Rka;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

$ta = $_SESSION['ta'];
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page - 1) * $rows;

$npsn = isset($_POST['npsn']) ? $_POST['npsn'] : '';
$sekolah = isset($_POST['sekolah']) ? $_POST['sekolah'] : '';
$triwulan = isset($_POST['triwulan']) ? $_POST['triwulan'] : '';

$kr_all = array();
$res_kr = DB::select('call koderekening_lengkap()');
foreach ($res_kr as $key => $value) {
    $kr_all[$value->id] = $value;
}
$jsonrka = array();

// 'npsn', 'like', '%' .$npsn. '%'
$rka = Rka::ta($ta)->triwulan($triwulan)->npsn($npsn)->namaSekolah($sekolah)->with(['sekolah', 'program', 'kp'])->skip($offset)->take($rows)->get();
$rkacount = Rka::ta($ta)->triwulan($triwulan)->npsn($npsn)->namaSekolah($sekolah)->count();
// $rka['nomor_rekening']="tes";
foreach ($rka as $key => $value) {
    $jsonrka[$key] = $value;
    $jsonrka[$key]['nomor_rekening'] = $kr_all[$value->rekening_id]->path;
    $jsonrka[$key]['nama_rekening'] = $kr_all[$value->rekening_id]->nama_rekening;
}


$result = array();
$result["total"] = $rkacount;
$result["rows"] = $jsonrka;

echo json_encode($result);
