<?php
use App\Models\BarangPersediaan;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
// $ta= $_SESSION['ta'];
	
if (!empty($_POST)) {
    // $request = (object)$_POST;
    $barangpersediaan= new BarangPersediaan();
	$barangpersediaan->fill($_POST);
	$sukses = $barangpersediaan->save();

	if ($sukses){	
		echo json_encode($barangpersediaan);
	} else {
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
}
?>