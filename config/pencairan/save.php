<?php
use App\Models\Pencairan;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$ta= $_SESSION['ta'];
	
if (!empty($_POST)) {
    $request = (object)$_POST;
	$sukses=false;
	$cek= Pencairan::ta($ta)->triwulan($request->triwulan)->npsn($request->npsn)->count();
	if($cek==0){	
		$pencairanbaru = New Pencairan();
		$pencairanbaru->ta= $request->ta;
		$pencairanbaru->triwulan= $request->triwulan;
		$pencairanbaru->npsn= $request->npsn;
		$pencairanbaru->saldo= $request->saldo;
		if($pencairanbaru->save()){
			$sukses=$pencairanbaru->sisa()->create([
			    'saldo' => $request->saldo
			]);
		}	

	}
	



	if ($sukses){	
		echo json_encode($pencairanbaru);
	} else {
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
}
?>