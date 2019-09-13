<?php
use App\Models\Sekolah;
use App\Models\Saldo;
use App\Models\Belanjathlalu;
header('Content-Type: application/json');
include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$id= $_GET['id'];
$ta= $_SESSION['ta'];
$npsn = (!empty($_POST['npsn'])) ? $_POST['npsn'] : ($_SESSION['role']=="2") ? $_SESSION['username'] : '' ;
$triwulan= (!empty($_POST['triwulan'])) ? $_POST['triwulan'] : (!empty($_SESSION['triwulan'])) ? $_SESSION['triwulan'] : '' ;
	
if (!empty($_POST)) {
    $request = (object)$_POST;
    $belanjaan= Belanjathlalu::find($id);
    $sukses= false;
    $pesan="";
    $triwulan= (!empty($_POST['triwulan'])) ? $_POST['triwulan'] : triwulan($request->tanggal_belanja);

    $tanggalbelanja= DateTime::createFromFormat('d-m-Y', $request->tanggal_belanja);

    $saldo= Saldo::ta($ta-1)->npsn($npsn)->first();

	$nilailama= $belanjaan->nilai;
	$nilaibaru= $request->nilai;

	if ($nilaibaru != $nilailama) {
		$selisih= $nilaibaru-$nilailama;
	}
	else{
		$selisih= 0;
	}
	// echo $selisih;
	if($selisih != 0){
		$belanjaan->nilai += $selisih;
		$saldo->sisa -= $selisih;
	}

	if ($saldo->sisa >= 0) {
		$belanjaan->triwulan= $triwulan;
		$belanjaan->program_id= $request->program;
		$belanjaan->pembiayaan_id= $request->kp;
		$belanjaan->rekening_id= $request->rekening;
		$belanjaan->nama= $request->nama;
		$belanjaan->tanggal_belanja= $tanggalbelanja;

		if($belanjaan->save()){
			$sukses= $saldo->save();
		}
		else{
			$pesan="Terdapat error! Belanja tidak dapat di update";
		}
	}
	else{
		$pesan="Sisa saldo tahun lalu tidak cukup";
	}


	if ($sukses){	
		echo json_encode($request);
	}
	else {
		echo json_encode(array('errorMsg'=>$pesan));
	}
}
?>