<?php
use App\Models\Sekolah;
use App\Models\Rka;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$id= $_GET['id'];
	
if (!empty($_POST)) {
    $request = (object)$_POST;
    $sekolah = Sekolah::npsn($request->npsn)->first();
    $pagu = $sekolah->pagus()->ta($request->ta)->first();
    $sisapagu = $pagu->sisa()->first();
    $tw="tw";
    $triwulan= $tw.$request->triwulan;
    $rkalama= $sekolah->rkas()->find($id);
    $nilailama= $rkalama->nilai;
    $nilaibaru= $request->nilai[0];

    // echo json_encode($request);
	
	if ($nilaibaru != $nilailama) {
		$selisih= $nilaibaru-$nilailama;
	}
	else{
		$selisih= 0;
	}
	// echo $selisih;
	if($selisih != 0){
		if(($sisapagu->$triwulan - $selisih) < 0){
			echo json_encode(array('errorMsg'=>'Sisa Pagu tidak cukup.'));
			exit;
		}
		else{
			$sisarka = $rkalama->sisa()->first();

			$sisarka->nilai += $selisih;
			$sisapagu->$triwulan -= $selisih;
			$rkalama->nilai += $selisih;

			$sisarka->save();
			$sisapagu->save();
			// echo json_encode($sisarka);
			
		}
	}

	// echo "tos";
	$rkalama->program_id = $request->idprogram[0];
	$rkalama->pembiayaan_id = $request->idkp[0];
	$rkalama->rekening_id = $request->idrekening[0];
	$simpanrka = $rkalama->save();
	// echo $sisapagu->$triwulan;


	if ($simpanrka){	
		// echo json_encode($rkalama);
		header('location: /rka.php');
	}
	else {
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
}
?>