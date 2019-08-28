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
		// $sekolahlama->fill($_POST);
		$sekolahlama->password= $sekolahlama->npsn;
		$sukses= $sekolahlama->save();
	}
	else{
		$sukses= false;
		$pesan="Sekolah tidak ditemukan";
	}

	if ($sukses){	
		echo json_encode(
			array(
				'success' => true,
				'sekolah' => $sekolahlama
			)
		);
	} else {
		echo json_encode(
			array(
				'errorMsg'=>'Password gagal di ubah. '.$pesan
			)
		);
	}
}
?>