<?php 
	use App\Models\KodeRekening;
	include_once 'config/db.php';
	include_once 'ceklogin.php';
	require_once 'config/dbmanager.php'; 
// echo "hell";
	$id = $_GET['id'];
	$kr = KodeRekening::find($id);
	if (!empty($kr)) {
		if ($kr->delete()) {
			header('location: tabelrekening.php?deleted');
		}
		else {
			header('location: tabelrekening.php?errdelete');
		}
	}
	

?>