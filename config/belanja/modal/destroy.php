<?php
use App\Models\BelanjaModal;
// use App\Models\Rka;

include_once '../../db.php';
// include_once '../../ceklogin.php';
require_once '../../dbmanager.php';
header('Content-Type: application/json');
	
if (!empty($_POST)) {
    $request = (object)$_POST;
	$id= (int)$request->id;
	
	$bm= BelanjaModal::find($id);
	// echo(json_encode($id));
	$hapus= $bm->delete();
	if($hapus){
		echo json_encode(array('success'=>true));
	}
	else{
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
	
	
}
?>