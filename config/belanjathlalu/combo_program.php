<?php

// use Illuminate\Database\Capsule\Manager as DB;
use App\Models\KodeProgram;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

// $ta = $_SESSION['ta'];

// $npsn = isset($_GET['npsn']) ? $_GET['npsn'] : '';
// $triwulan = isset($_GET['triwulan']) ? $_GET['triwulan'] : '';
$q = isset($_POST['q']) ? strval($_POST['q']) : '';

$program= KodeProgram::where('nama_program','like', '%'.$q.'%')->get();
// $pagucount= Sekolah::count();
$result = array();

foreach ($program as $key => $p) {
	# code...
	$result[$key]["id"] = $p->id;
	$result[$key]["nama_program"] = $p->nama_program;
}

echo json_encode($result);