<?php
use App\Models\Pencairan;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
	
if (!empty($_POST)) {
    $request = (object)$_POST;
	$id= $request->id;
	$pencairan_lama = Pencairan::find($id);
	if (!empty($pencairan_lama)) {
		# code...
		$sisa = $pencairan_lama->sisa()->delete(); 
		if($sisa){
			$sukses= $pencairan_lama->delete();
		}
		if ($sukses){	
			echo json_encode(array('success'=>true));
		} else {
			echo json_encode(array('errorMsg'=>'Some errors occured.'));
		}
	}
	else{
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
}
?>