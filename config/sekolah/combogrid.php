<?php

// use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Sekolah;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

// $ta = $_SESSION['ta'];

// $npsn = isset($_GET['npsn']) ? $_GET['npsn'] : '';
// $triwulan = isset($_GET['triwulan']) ? $_GET['triwulan'] : '';
$q = isset($_POST['q']) ? strval($_POST['q']) : '';

$pagu= Sekolah::with(['kecamatannya'])->namaSekolah($q)->get();
$pagucount= Sekolah::count();
$result = array();
$result["total"] = $pagucount;
$result["rows"] = $pagu;

echo json_encode($result);