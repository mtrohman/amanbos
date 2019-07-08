<?php
use App\Models\Sekolah;
use App\Models\Rka;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$ta= $_SESSION['ta'];
	
if (!empty($_POST)) {
    $request = (object)$_POST;
    echo json_encode($request);
    // echo $request->npsn[0];
	// $sekolah = Sekolah::where('npsn',$request->npsn[0]);
	$sekolah = Sekolah::npsn($request->npsn[0])->first();
	// echo json_encode($sekolah);
	$datarka = array();
	for ($i=0; $i < $request->totalbaris ; $i++) { 
		$datarka[$i] = new Rka([
			'ta' => $request->ta[$i],
			'npsn' => $request->npsn[$i],
			'triwulan' => $request->triwulan[$i],
			'program_id' => $request->idprogram[$i],
			'pembiayaan_id' => $request->idkp[$i],
			'rekening_id' => $request->idrekening[$i],
			'nilai' => $request->nilai[$i],
		]);
	}

	
	if ($sekolah->rkas()->saveMany($datarka)){	
		// echo ;
		header('location: /rka.php');
	} else {
		// echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}
}
?>