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

$bp= Belanja::find($id)->belanja_persediaan()->skip($offset)->take($rows)->get();
$bpall= Belanja::find($id)->belanja_persediaan();
$bpcount= $bpall->count();
$bpfooter= array(
	'nama_persediaan' => 'Total',
	'qty' => (int)$bpall->sum('qty'),
	// 'harga_satuan' => (float)$bpall->sum('harga_satuan'),
	'total' => (float)$bpall->sum('total'),

);

$result = array();
$result["total"] = $bpcount;
$result["rows"] = $bp;
$result["footer"] = array($bpfooter);

echo json_encode($result);
