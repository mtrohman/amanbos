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
    // $pagu = $sekolah->pagus()->ta($request->ta)->first();

	$belanjasampaitw2= $belanja->sampaiTriwulan(2)->get()->sum('nilai');
    $paguperubahan= PaguPerubahan::npsn($npsn)->ta($ta)->first();
    $pagu= $paguperubahan->pagu;
    $rkaperubahan= Rka::npsn($npsn)->ta($ta)->where('jenis_rka','RKA Perubahan');
    $rkaperubahansampaitw3= $rkaperubahan->sampaiTriwulan(3)->get()->sum('nilai');
    $rkaperubahansampaitw4= $rkaperubahan->sampaiTriwulan(4)->get()->sum('nilai');

    $jatahtw3= $pagu*(80/100);
    $jatahtw4= $pagu*(100/100);
    $sisapagu3= $jatahtw3-$belanjasampaitw2-$rkaperubahansampaitw3;
    $sisapagu4= $jatahtw4-$belanjasampaitw2-$rkaperubahansampaitw4;

    $tw="tw";
    $sisapagu="sisapagu";

    $triwulan= $tw.$request->triwulan;
    $sisa= $sisapagu.$request->triwulan;

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
		if(($$sisa - $selisih) < 0){
			echo json_encode(array('errorMsg'=>'Sisa Pagu tidak cukup.'));
			exit;
		}
		else{
			$sisarka = $rkalama->sisa()->first();

			$sisarka->nilai += $selisih;

			// $sisapagu->$triwulan -= $selisih;
			$paguperubahan->sisa -= $selisih;

			$rkalama->nilai += $selisih;

			$sisarka->save();

			$paguperubahan->save();
			// echo json_encode($sisarka);
			
		}
	}

	// echo "tos";
	$rkalama->uraian = $request->uraian[0];
	$rkalama->program_id = $request->idprogram[0];
	$rkalama->pembiayaan_id = $request->idkp[0];
	$rkalama->rekening_id = $request->idrekening[0];
	$simpanrka = $rkalama->save();
	// echo $sisapagu->$triwulan;


	if ($simpanrka){	
		// echo json_encode($rkalama);
		header('location: /rkaperubahan.php');
	}
	else {
		// echo json_encode(array('errorMsg'=>'Some errors occured.'));
		echo "<script>alert(\"Maaf Tidak dapat menyimpan\"); window.location.href=\"/rkaperubahan.php\";</script>";
	}
}
?>