<?php
use App\Models\BelanjaPersediaan;
// use App\Models\Rka;

include_once '../../db.php';
// include_once '../../ceklogin.php';
require_once '../../dbmanager.php';
header('Content-Type: application/json');
	
if (!empty($_POST)) {
    $request = (object)$_POST;
	$id= (int)$request->id;
	
	$bp= BelanjaPersediaan::find($id);
	// echo(json_encode($id));
	$hapus= $bp->delete();
	if($hapus){
		echo json_encode(array('success'=>true));
	}
	else{
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}

	/*if (!empty($rka)) {
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
	}*/
	
	
}
?>