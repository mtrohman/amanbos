<?php
use App\Models\Sekolah;
use App\Models\Rka;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
header('Content-Type: application/json');
	
if (!empty($_POST)) {
    $request = (object)$_POST;
	$id= $request->id;
	
	$rka= Rka::find($id);
	if (!empty($rka)) {
		$tw="tw";
		$triwulan= $tw.$rka->triwulan;
		$rkanilai= $rka->nilai;
		$rkasisa= $rka->sisa()->first();
		$pagu = Sekolah::npsn($rka->npsn)->first()->pagus()->ta($rka->ta)->first();
		$pagusisa = $pagu->sisa()->first();

		$deleterkasisa= $rkasisa->delete();
		if($deleterkasisa){
			$deleterka= $rka->delete();
			if($deleterka) {
				$pagusisa->$triwulan += $rkanilai;
				if($pagusisa->save()){
					echo json_encode(array('success'=>true));
				}
				else{
					echo json_encode(array('errorMsg'=>'Some errors occured. #4'));
				}
			}
			else{
				echo json_encode(array('errorMsg'=>'Some errors occured. #3'));
			}
		}
		else{
			echo json_encode(array('errorMsg'=>'Some errors occured. #2'));
		}

		// echo(json_encode($rkanilai));
	}
	else{
		echo json_encode(array('errorMsg'=>'Some errors occured. #1'));
	}
	
	// echo json_encode($rkasisa);
	// $pagu_lama = Pagu::find($id);
	// if (!empty($pagu_lama)) {
	// 	# code...
	// 	$sisa = $pagu_lama->sisa()->delete(); 
	// 	if($sisa){
	// 		$sukses= $pagu_lama->delete();
	// 	}
	// 	if ($sukses){	
	// 		echo json_encode(array('success'=>true));
	// 	} else {
	// 		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	// 	}
	// }
	// else{
	// 	echo json_encode(array('errorMsg'=>'Some errors occured.'));
	// }
}
?>