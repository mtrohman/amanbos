<?php

use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Rka;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

// $ta = $_SESSION['ta'];

// $npsn = isset($_GET['npsn']) ? $_GET['npsn'] : '';
if (isset($_POST['npsn'])) {
    	$npsn=$_POST['npsn'];
    }
    else if(isset($_GET['npsn'])){
    	$npsn=$_GET['npsn'];
    }
    else{
    	$npsn='';
    }

$triwulan = isset($_GET['triwulan']) ? $_GET['triwulan'] : '';
$q = isset($_POST['q']) ? strval($_POST['q']) : '';

$kr_all = array();
$res_kr = DB::select('call koderekening_lengkap()');
foreach ($res_kr as $key => $value) {
    $kr_all[$value->id] = $value;
}
$jsonrka = array();

$rka = Rka::with(['sekolah', 'program', 'kp', 'sisa'])->perubahan()->npsn($npsn)->ta($_SESSION['ta'])->sampaiTriwulan(4)->uraian($q)->get();
foreach ($rka as $key => $value) {
    $jsonrka[$key] = $value;
    $jsonrka[$key]['nomor_rekening'] = $kr_all[$value->rekening_id]->path;
    $jsonrka[$key]['nama_rekening'] = $kr_all[$value->rekening_id]->nama_rekening;
}

echo json_encode($jsonrka);
