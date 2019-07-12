<?php
use App\Models\Pencairan;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$id= $_GET['id'];
	
if (!empty($_POST)) {
    $request = (object)$_POST;
	$pencairanlama= Pencairan::find($id);
	$nilailama= $pencairanlama->saldo;
	$nilaibaru= $request->saldo;

	if ($nilaibaru != $nilailama) {
		$selisih= $nilaibaru-$nilailama;
	}
	else{
		$selisih= 0;
	}
	// echo $selisih;
	if($selisih != 0){
		$pencairanlama->saldo += $selisih;
		if($pencairanlama->save()){
			$pencairanlama->sisa->saldo += $selisih;
			$sukses=$pencairanlama->push();
		}

	}

	if ($sukses){	
		echo json_encode($request);
	} else {
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
}
?>