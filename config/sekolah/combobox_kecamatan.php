<?php

// use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Kecamatan;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

// $ta = $_SESSION['ta'];

// $npsn = isset($_GET['npsn']) ? $_GET['npsn'] : '';
// $triwulan = isset($_GET['triwulan']) ? $_GET['triwulan'] : '';
$q = isset($_POST['q']) ? strval($_POST['q']) : '';

$kecamatan= Kecamatan::namaKecamatan($q)->get();
// $pagucount= Sekolah::count();
$result = array();

foreach ($kecamatan as $key => $k) {
	# code...
	$result[$key]["id"] = $k->id;
	$result[$key]["nama_kecamatan"] = $k->nama_kecamatan;
}

echo json_encode($result);