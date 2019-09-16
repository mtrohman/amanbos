<?php

// use Illuminate\Database\Capsule\Manager as DB;
use App\Models\KodeBarang;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

// $ta = $_SESSION['ta'];

// $npsn = isset($_GET['npsn']) ? $_GET['npsn'] : '';
// $triwulan = isset($_GET['triwulan']) ? $_GET['triwulan'] : '';
$q = isset($_POST['q']) ? strval($_POST['q']) : '';
$pid= $_GET['pid'];
$barangs= KodeBarang::where('parent_rekening',$pid)->where('nama_barang','like', '%'.$q.'%')->get();
// $barangs= KodeBarang::all();
// $pagucount= Sekolah::count();
$result = array();
$i=0;
foreach ($barangs as $barang) {
	# code...
	$result[$i]["id"] = $barang->id;
	$result[$i]["kode_barang"] = $barang->kode_barang;
	$result[$i]["nama_barang"] = $barang->nama_barang;
	$i++;
}

// echo json_encode($result);
echo json_encode($result);
// print_r($result);