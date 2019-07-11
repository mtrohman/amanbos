<?php
use App\Models\Sekolah;
use App\Models\Rka;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$ta= $_SESSION['ta'];
	
if (!empty($_POST)) {
    $request = (object)$_POST;
    echo(json_encode($request));

	// end
	/*if ($sekolah->rkas()->saveMany($datarka)){	
		// echo ;
		header('location: /rka.php');
	} else {
		// echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}*/
}
?>