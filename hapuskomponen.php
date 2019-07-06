<?php 
	use App\Models\KodePembiayaan;
	include_once 'ceklogin.php';
	require_once 'config/dbmanager.php'; 

	$id = $_GET['id'];
	// $delete	= mysqli_query($link,"DELETE FROM dokinvestasi WHERE id=$id");
	$kp = KodePembiayaan::find($id);
	if (!empty($kp)) {
		if ($kp->delete()) {
			header('location: tabelkomponen.php?deleted');
		}
		else {
			header('location: tabelkomponen.php?errdelete');
		}
	}
	

?>