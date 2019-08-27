<?php
use App\Models\Sekolah;
use App\Models\Rka;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$ta= $_SESSION['ta'];
	
if (!empty($_POST)) {
    $request = (object)$_POST;
    $error= array();
    // echo json_encode($request);
    // echo $request->npsn[0];
	// $sekolah = Sekolah::where('npsn',$request->npsn[0]);
	$sekolah = Sekolah::npsn($request->npsn)->first();
	$datarka = array();
	$pagu=$sekolah->pagus()->ta($ta)->first();
	// echo json_encode($pagu->sisa()->first());
	$tw="tw";
	$totalsementara=0;
	for ($i=0; $i < $request->totalbaris ; $i++) { 
		$triwulan= $tw.$request->triwulan;
		$totalsementara += $request->nilai[$i];
		if ($totalsementara <= $pagu->sisa()->first()->$triwulan) {
			$datarka[$i] = new Rka([
				'ta' => $request->ta,
				'npsn' => $request->npsn,
				'triwulan' => $request->triwulan,
				'uraian' => $request->uraian[$i],
				'program_id' => $request->idprogram[$i],
				'pembiayaan_id' => $request->idkp[$i],
				'rekening_id' => $request->idrekening[$i],
				'nilai' => $request->nilai[$i],
			]);
			// $error[$i]=false;
		}
		else{
			$error[$i]=true;
		}
	}
	// echo json_encode($datarka);
	// echo intval(empty($error));
	// echo $totalsementara;
	if(empty($error)){
		$simpanrkas=$sekolah->rkas()->saveMany($datarka);
		if ($simpanrkas) {
			$simpansisarkas=collect($simpanrkas)->each(function ($item, $key) {
				$item->sisa()->create(['nilai' => $item->nilai]);
			});
			
			$sisapagu=$pagu->sisa()->first();
			echo json_encode($sisapagu);
			echo $sisapagu->$triwulan - collect($simpanrkas)->sum('nilai');
			$sisapagu->$triwulan= $sisapagu->$triwulan - collect($simpanrkas)->sum('nilai');
			$sisapagu->save();
		}

		echo json_encode($simpanrkas);
		if ($simpanrkas) {
			header('location: /rka.php');
		}	
	}
	else{
		echo "<script>";
		echo "alert(\"Maaf Pagu tidak cukup\");";
		echo "window.location.href=\"/rka.php\";";
		echo "</script>";
	}



	// end
	/*if ($sekolah->rkas()->saveMany($datarka)){	
		// echo ;
		header('location: /rka.php');
	} else {
		// echo json_encode(array('errorMsg'=>'Some errors occured.'));
	}*/
}
?>