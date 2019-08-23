<?php
use App\Models\Pencairan;
use App\Models\Saldo;
include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$id= $_GET['id'];
	
if (!empty($_POST)) {
    $request = (object)$_POST;
	$pencairanlama= Pencairan::find($id);
	$nilailama= $pencairanlama->saldo;
	$nilaibaru= $request->saldo;
	$tanggalpencairan= DateTime::createFromFormat('d-m-Y', $request->tanggal_pencairan);

	if ($nilaibaru != $nilailama) {
		$selisih= $nilaibaru-$nilailama;
	}
	else{
		$selisih= 0;
	}
	$sukses=false;
	// echo $selisih;

	$pencairanlama->tanggal_pencairan= $tanggalpencairan;
	if($selisih != 0){
		$pencairanlama->saldo += $selisih;
		if($pencairanlama->save()){
			// $pencairanlama->sisa->saldo += $selisih;
			// $sukses=$pencairanlama->push();
			$saldo= Saldo::firstOrNew(
				[
					'ta' => $pencairanlama->ta,
					'npsn' => $request->npsn
				]
			);
			$saldo->sisa += $selisih;
			$sukses=$saldo->save();

		}

	}
	$sukses=$pencairanlama->save();

	if ($sukses){	
		echo json_encode($request);
	} else {
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
}
?>