<?php
use App\Models\Sekolah;
use App\Models\Belanja;
header('Content-Type: application/json');
include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$id= $_GET['id'];
$npsn = (!empty($_POST['npsn'])) ? $_POST['npsn'] : ($_SESSION['role']=="2") ? $_SESSION['username'] : '' ;
$triwulan= (!empty($_POST['triwulan'])) ? $_POST['triwulan'] : (!empty($_SESSION['triwulan'])) ? $_SESSION['triwulan'] : '' ;
	
if (!empty($_POST)) {
    $request = (object)$_POST;
    $belanjaan= Belanja::find($id);
    $tanggalbelanja= DateTime::createFromFormat('d-m-Y', $request->tanggal_belanja);
    $rka=$belanjaan->rka()->with(['sisa'])->first();
    $sekolah = $rka->sekolah()->npsn($rka->npsn)->first();
    $saldo= $sekolah->saldos()->where('ta',$rka->ta)->first();

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
		$rka->sisa->nilai -= $selisih;
		$saldo->sisa -= $selisih;
		if($rka->sisa->nilai >= 0){
			if ($saldo->sisa >= 0) {
				$belanjaan->tanggal_belanja= $tanggalbelanja;
				$belanjaan->nama= $request->nama;
				$belanjaan->nomor= $request->nomor;
				$belanjaan->penerima= $request->penerima;
				$belanjaan->ppn= $request->ppn;
				$belanjaan->pph21= $request->pph21;
				$belanjaan->pph23= $request->pph23;
				
				

				if($belanjaan->save()){
					$sukses=($rka->push() && $saldo->save());
				}
				else{
					$pesan="belanjaan gagal tersimpan";
				}
			}
			else{
				$pesan="saldo tidak cukup";
			}
		}
		else{
			$pesan="sisa rka tidak cukup";
		}

	}
	else{
		$belanjaan->tanggal_belanja= $tanggalbelanja;
		$belanjaan->nama= $request->nama;
		$belanjaan->nomor= $request->nomor;
		$belanjaan->penerima= $request->penerima;
		$belanjaan->ppn= $request->ppn;
		$belanjaan->pph21= $request->pph21;
		$belanjaan->pph23= $request->pph23;
		$sukses=$belanjaan->save();
	}
    
	// echo $sisapagu->$triwulan;


	if ($sukses){	
		echo json_encode($request);
		// header('location: /rka.php');
	}
	else {
		echo json_encode(array('errorMsg'=>$pesan,'rka'=>$rka,'saldo'=>$saldo,'belanjaan'=>$belanjaan));
	}
}
?>