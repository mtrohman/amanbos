<?php

use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Belanja;
use App\Models\Rka;


include_once '../../db.php';
// include_once '../../ceklogin.php';
require_once '../../dbmanager.php';

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page - 1) * $rows;


// $jsonrka = array();
// $jsonbelanja = array();

// 'npsn', 'like', '%' .$npsn. '%'
// $belanja = Belanja::with(['rka.program','rka.kp','rka.sekolah','rka.rekening'])->ta($ta)->triwulan($triwulan)->npsn($npsn)->namaSekolah($sekolah)->skip($offset)->take($rows)->get();

// $belanjacount = Belanja::with(['rka.program','rka.kp','rka.sekolah'])->ta($ta)->triwulan($triwulan)->npsn($npsn)->namaSekolah($sekolah)->count();


$id= $_GET['id'];

$bm= Belanja::find($id)->belanja_modal()->with('kd_barang')->skip($offset)->take($rows)->get();
$bmall= Belanja::find($id)->belanja_modal();
$bmcount= $bmall->count();
$bmfooter= array(
	'nama_barang' => 'Total',
	'qty' => (int)$bmall->sum('qty'),
	// 'harga_satuan' => (float)$bmall->sum('harga_satuan'),
	'total' => (float)$bmall->sum('total'),

);

$result = array();
$result["total"] = $bmcount;
$result["rows"] = $bm;
$result["footer"] = array($bmfooter);

echo json_encode($result);
