<?php
use App\Models\Saldo;
use App\Models\Belanjathlalu;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
header('Content-Type: application/json');
	
if (!empty($_POST)) {
    $request        = (object) $_POST;
    $id             = $request->id;
    $belanjaan_lama = Belanjathlalu::find($id);
    $sukses=false;

    if (!empty($belanjaan_lama)) {
    	$nilaibelanja = $belanjaan_lama->nilai;
    	
    	$saldo      = Saldo::where([
            'ta'   => ($belanjaan_lama->ta - 1),
            'npsn' => $belanjaan_lama->npsn,
        ])->first();
        $saldo->sisa += $nilaibelanja;
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
    	
    	if ($deletechild) {
    		if ($belanjaan_lama->delete()) {
    			if($saldo->save()){
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
	
}
?>