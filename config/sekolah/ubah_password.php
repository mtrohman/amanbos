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
		if ($sekolahlama->password==$request->password_lama) {
			# code...
			$sekolahlama->password= $request->password;
			$sukses= $sekolahlama->save();
		}
		else{
			$sukses= false;
			$pesan="Password Lama anda salah";
		}
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