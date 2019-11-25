<?php
use App\Models\BarangPersediaan;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$id= $_GET['id'];
	
if (!empty($_POST)) {
    $barangpersediaan= BarangPersediaan::find($id);
	if (!empty($barangpersediaan)) {
		$barangpersediaan->fill($_POST);
		$sukses = $barangpersediaan->save();
	}
	else{
		$sukses=false;
	}


	if ($sukses){	
		echo json_encode($barangpersediaan);
	} else {
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
}
?>