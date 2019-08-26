<?php
use App\Models\PaguPerubahan;
use App\Models\Belanja;


include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$ta= $_SESSION['ta'];
	
if (!empty($_POST)) {
    $request = (object)$_POST;
	$pagu=$request->pagu;
	$belanjatw1= Belanja::npsn($request->npsn)->ta($ta)->triwulan(1)->get()->sum('nilai');
	$belanjatw2= Belanja::npsn($request->npsn)->ta($ta)->triwulan(2)->get()->sum('nilai');
	$sisa= $pagu-$belanjatw1-$belanjatw2;
	$pagu_baru='';
	$pagu_baru = PaguPerubahan::updateOrCreate(
		['ta' => $ta, 'npsn' => $request->npsn],
		[
			'pagu' => $pagu,
			'sisa' => $sisa
		]
	);

	if ($pagu_baru){	
		echo json_encode($pagu_baru);
	} else {
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
}
?>