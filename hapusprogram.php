<?php 
	use App\Models\KodeProgram;
	include_once 'ceklogin.php';
	require_once 'config/dbmanager.php'; 

	$id = $_GET['id'];
	// $delete	= mysqli_query($link,"DELETE FROM dokinvestasi WHERE id=$id");
	$pk = KodeProgram::find($id);
	if (!empty($pk)) {
		if ($pk->delete()) {
			header('location: tabelprogram.php?deleted');
		}
		else {
			header('location: tabelprogram.php?errdelete');
		}
	}
	

?>