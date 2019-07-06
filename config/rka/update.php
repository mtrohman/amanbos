<?php
use App\Models\Pagu;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$id= $_GET['id'];
	
if (!empty($_POST)) {
    $request = (object)$_POST;
	$pagu=$request->pagu;
	$tw1= (20/100)*$pagu;
	$tw2= (40/100)*$pagu;
	$tw3= (20/100)*$pagu;
	$tw4= (20/100)*$pagu;
	$sukses=false;

	$pagu_lama = Pagu::find($id);
	$pagu_lama->pagu= $pagu;
	$pagu_lama->tw1= $tw1;
	$pagu_lama->tw2= $tw2;
	$pagu_lama->tw3= $tw3;
	$pagu_lama->tw4= $tw4;

	if($pagu_lama->save()){
		$sisa_pagu= $pagu_lama->sisa()->updateOrCreate(
		['pagu_id'=>$pagu_lama->id],
		[
			'tw1' => $tw1,
			'tw2' => $tw2,
			'tw3' => $tw3,
			'tw4' => $tw4,
		]);
		$sukses = ($sisa_pagu) ? true : false;
	}

	if ($sukses){	
		echo json_encode($pagu_lama);
	} else {
		echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
}
?>