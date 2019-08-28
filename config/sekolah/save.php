<?php
use App\Models\Sekolah;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
	
if (!empty($_POST)) {
    $request = (object)$_POST;
	$sukses=false;
	$ceknpsn= Sekolah::npsn($request->npsn)->count();
	$pesan="";
	if ($ceknpsn!=0) {
		$sukses= false;
		$pesan="NPSN sudah terdaftar";
	}
	else{
		$sekolahbaru= new Sekolah();
		$sekolahbaru->fill($_POST);
		$sekolahbaru->password= $request->npsn;
		$sukses= $sekolahbaru->save();
	}
			



	if ($sukses){	
		echo json_encode($sekolahbaru);
	} else {
		echo json_encode(
			array(
				'errorMsg'=>'Data Sekolah Gagal Di Simpan. '.$pesan
			)
		);
	}
}
?>