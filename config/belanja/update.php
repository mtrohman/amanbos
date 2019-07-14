<?php
use App\Models\Sekolah;
// use App\Models\Rka;
header('Content-Type: application/json');
include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$id= $_GET['id'];
$npsn = (!empty($_POST['npsn'])) ? $_POST['npsn'] : ($_SESSION['role']=="2") ? $_SESSION['username'] : '' ;
$triwulan= (!empty($_POST['triwulan'])) ? $_POST['triwulan'] : (!empty($_SESSION['triwulan'])) ? $_SESSION['triwulan'] : '' ;
	
if (!empty($_POST)) {
    $request = (object)$_POST;
    $sekolah = Sekolah::npsn($npsn)->first();
    $rka=$sekolah->rkas()->with(['sisa'])->where('id',$request->rka_id)->first();
    $saldo=$sekolah->pencairans()->with(['sisa'])->triwulan($rka->triwulan)->ta($rka->ta)->first();
    
    $tanggalbelanja= DateTime::createFromFormat('d-m-Y', $request->tanggal_belanja);

    $belanjaan= $rka->belanja()->find($id);
    $nilailama= $belanjaan->nilai;
	$nilaibaru= $request->nilai;

    $sukses=false;

    if ($nilaibaru != $nilailama) {
		$selisih= $nilaibaru-$nilailama;
	}
	else{
		$selisih= 0;
	}
	// echo $selisih;
	if($selisih != 0){
		$belanjaan->nilai += $selisih;
		if($belanjaan->save()){
			$rka->sisa->nilai -= $selisih;
			$saldo->sisa->saldo -= $selisih;
			$sukses=($rka->push() && $saldo->push());
		}

	}
    
	// echo $sisapagu->$triwulan;


	if ($sukses){	
		echo json_encode($request);
		// header('location: /rka.php');
	}
	else {
		echo json_encode(array('errorMsg'=>'Some errors occured.','rka'=>$rka,'saldo'=>$saldo,'belanjaan'=>$belanjaan));
	}
}
?>