<?php 
	use App\Models\Sekolah;
	// include_once 'ceklogin.php';
	require_once 'config/dbmanager.php'; 

	$npsn = (!empty($_GET['npsn']))? $_GET['npsn'] : '';
	$all = (isset($_GET['all']))? true : false;
	$ta = $_GET['ta'];
	$triwulan = $_GET['tw'];

	$sekolah= Sekolah::npsn($npsn)->first();
	$saldo= $sekolah->saldos()->ta($ta)->first()->sisa;
	// echo json_encode($all);

	// if (!empty($kp)) {
	// 	if ($kp->delete()) {
	// 		header('location: tabelkomponen.php?deleted');
	// 	}
	// 	else {
	// 		header('location: tabelkomponen.php?errdelete');
	// 	}
	// }
	

?>