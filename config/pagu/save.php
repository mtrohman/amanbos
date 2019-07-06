<?php
use App\Models\Pagu;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$ta= $_SESSION['ta'];
	
if (!empty($_POST)) {
    $request = (object)$_POST;
	$pagu=$request->pagu;
	$tw1= (20/100)*$pagu;
	$tw2= (40/100)*$pagu;
	$tw3= (20/100)*$pagu;
	$tw4= (20/100)*$pagu;
	$sukses=false;
	$pagu_baru = Pagu::updateOrCreate(
		['ta' => $ta, 'npsn' => $request->npsn],
		[
			'pagu' => $pagu,
			'tw1' => $tw1,
			'tw2' => $tw2,
			'tw3' => $tw3,
			'tw4' => $tw4
		]
	);

	if($pagu_baru){
		$sisa_pagu= $pagu_baru->sisa()->updateOrCreate(
		['pagu_id'=>$pagu_baru->id],
		[
			'tw1' => $tw1,
			'tw2' => $tw2,
			'tw3' => $tw3,
			'tw4' => $tw4,
		]);
		$sukses = ($sisa_pagu) ? true : false;
	}

	if ($sukses){	
		echo json_encode($pagu_baru);
	} else {
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
}
?>