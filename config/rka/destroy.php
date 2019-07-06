<?php
use App\Models\Pagu;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
	
if (!empty($_POST)) {
    $request = (object)$_POST;
	$id= $request->id;
	$pagu_lama = Pagu::find($id);
	if (!empty($pagu_lama)) {
		# code...
		$sisa = $pagu_lama->sisa()->delete(); 
		if($sisa){
			$sukses= $pagu_lama->delete();
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