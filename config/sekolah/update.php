<?php
use App\Models\Sekolah;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
	
if (!empty($_POST)) {
    $request = (object)$_POST;
	$sukses=false;
	$sekolahlama= Sekolah::find($_GET['id']);
	$pesan="";
	if (!empty($sekolahlama)) {
		$sekolahlama->fill($_POST);
		// $sekolahbaru->password= $request->npsn;
		$sukses= $sekolahlama->save();
	}
	else{
		$sukses= false;
		$pesan="Sekolah tidak ditemukan";
	}

	if ($sukses){	
		echo json_encode($sekolahlama);
	} else {
		echo json_encode(
			array(
				'errorMsg'=>'Data Sekolah Gagal Di Simpan. '.$pesan
			)
		);
	}
}
?>