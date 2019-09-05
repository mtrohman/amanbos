<?php

// use Illuminate\Database\Capsule\Manager as DB;
use App\Models\KodeRekening;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

// $ta = $_SESSION['ta'];

// $npsn = isset($_GET['npsn']) ? $_GET['npsn'] : '';
// $triwulan = isset($_GET['triwulan']) ? $_GET['triwulan'] : '';
$q = isset($_POST['q']) ? strval($_POST['q']) : '';

$krs= KodeRekening::orderBy('parent_id')->orderBy('id')->where('nama_rekening','like', '%'.$q.'%')->where('parent_id','!=',NULL)->get();
// $pagucount= Sekolah::count();
$result = array();

foreach ($krs as $key => $kr) {
	# code...
	$result[$key]["id"] = $kr->id;
	$result[$key]["nama_rekening"] = $kr->nama_rekening;
}

echo json_encode($result);