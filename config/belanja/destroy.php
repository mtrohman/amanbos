<?php
use App\Models\Saldo;
use App\Models\Belanja;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
header('Content-Type: application/json');
	
if (!empty($_POST)) {
    $request        = (object) $_POST;
    $id             = $request->id;
    $belanjaan_lama = Belanja::find($id);
    $sukses=false;
    if (!empty($belanjaan_lama)) {
    	$nilaibelanja = $belanjaan_lama->nilai;
    	$rka=$belanjaan_lama->rka()->with(['sisa'])->first();
    	// $rka= $belanjaan_lama->rka();
    	$saldo      = Saldo::where([
            'ta'   => $belanjaan_lama->rka->ta,
            'npsn' => $belanjaan_lama->rka->npsn,
        ])->first();
        $saldo->sisa += $nilaibelanja;
        $rka->sisa->nilai += $nilaibelanja;
        // $bm= $belanjaan_lama->belanja_modal();
        // $bm->delete();
        if ($belanjaan_lama->jenis_belanja==1) {
        	if(!empty($belanjaan_lama->belanja_modal()->count())){
        		$deletechild= $belanjaan_lama->belanja_modal()->delete();
        	}
        	else{
        		$deletechild=true;
        	}
        }
        elseif($belanjaan_lama->jenis_belanja==2){
        	if(!empty($belanjaan_lama->belanja_persediaan()->count())){
        		$deletechild= $belanjaan_lama->belanja_persediaan()->delete();
        	}
        	else{
        		$deletechild=true;
        	}
        }
        else{
        	$deletechild=true;
        }
    	
    	if ($deletechild) {
    		if ($belanjaan_lama->delete()) {
    			if($saldo->save() && $rka->push()){
    				$sukses=true;
    			}
    			$pesan="saldo gagal diperbaharui";
    		}
    		$pesan="data belanja gagal dihapus";
    	}
    	$pesan="data belanja modal/persediaan gagal dihapus";
    }
    else{
    	$pesan="Data Belanja tidak ditemukan";
    }

    if ($sukses){	
		echo json_encode(array('success'=>true));
	} else {
		echo json_encode(array('errorMsg'=>$pesan));
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
	
	// echo json_encode($rkasisa);
	// $pagu_lama = Pagu::find($id);
	// if (!empty($pagu_lama)) {
	// 	# code...
	// 	$sisa = $pagu_lama->sisa()->delete(); 
	// 	if($sisa){
	// 		$sukses= $pagu_lama->delete();
	// 	}
	// }
	// else{
	// 	echo json_encode(array('errorMsg'=>'Some errors occured.'));
	// }
}
?>