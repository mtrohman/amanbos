<?php
use App\Models\Pencairan;
use App\Models\Saldo;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$ta= $_SESSION['ta'];
	
if (!empty($_POST)) {
    $request = (object)$_POST;
	$sukses=false;
	$tanggalpencairan= DateTime::createFromFormat('d-m-Y', $request->tanggal_pencairan);
	if ($request->sumber_dana=="BOS") {
		$cek= Pencairan::sumberDana('BOS')->ta($ta)->triwulan($request->triwulan)->npsn($request->npsn)->count();
	}
	elseif($request->sumber_dana=="Dana Lainnya"){
		$cek=0;
	}
	else{
		$cek=-1;
	}
	if($cek==0){	
		$pencairanbaru = New Pencairan();
		$pencairanbaru->sumber_dana= $request->sumber_dana;
		$pencairanbaru->ta= $request->ta;
		$pencairanbaru->triwulan= $request->triwulan;
		$pencairanbaru->tanggal_pencairan= $tanggalpencairan;
		$pencairanbaru->npsn= $request->npsn;
		$pencairanbaru->saldo= $request->saldo;
		if($pencairanbaru->save()){
			$saldo= Saldo::firstOrNew(
				[
					'ta' => $ta,
					'npsn' => $request->npsn
				]
			);
			$saldo->sisa += $request->saldo;
			$sukses = $saldo->save();
			// $sukses=$pencairanbaru->sisa()->create([
			//     'saldo' => $request->saldo
			// ]);			
		}	

	}
	



	if ($sukses){	
		echo json_encode($pencairanbaru);
	} else {
		echo json_encode(
			array(
				'errorMsg'=>'Pencairan Dana BOS pada triwulan tsb sudah ada'
			)
		);
	}
}
?>