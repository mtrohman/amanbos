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
	$cek= Pencairan::ta($ta)->triwulan($request->triwulan)->npsn($request->npsn)->count();
	if($cek==0){	
		$pencairanbaru = New Pencairan();
		$pencairanbaru->ta= $request->ta;
		$pencairanbaru->triwulan= $request->triwulan;
		$pencairanbaru->tanggal_pencairan= $tanggalpencairan;
		$pencairanbaru->npsn= $request->npsn;
		$pencairanbaru->saldo= $request->saldo;
		if($pencairanbaru->save()){
			/*$sukses= Saldo::updateOrCreate(
				[
					'ta' => $ta,
					'npsn' => $request->npsn
				],
				[
					'sisa' => $request->saldo
				]
			);*/
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
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
}
?>