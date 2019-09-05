<?php

// use Illuminate\Database\Capsule\Manager as DB;
use App\Models\KodePembiayaan;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

// $ta = $_SESSION['ta'];

// $npsn = isset($_GET['npsn']) ? $_GET['npsn'] : '';
// $triwulan = isset($_GET['triwulan']) ? $_GET['triwulan'] : '';
$q = isset($_POST['q']) ? strval($_POST['q']) : '';

$kps= KodePembiayaan::where('nama_pembiayaan','like', '%'.$q.'%')->get();
// $pagucount= Sekolah::count();
$result = array();

foreach ($kps as $key => $kp) {
	# code...
	$result[$key]["id"] = $kp->id;
	$result[$key]["nama_pembiayaan"] = $kp->nama_pembiayaan;
}

echo json_encode($result);