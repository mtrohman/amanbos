<?php
use App\Models\Sekolah;
use App\Models\Rka;
use App\Models\Belanja;
use App\Models\PaguPerubahan;

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
	// $pagu=$sekolah->pagus()->ta($ta)->first();
	$belanja= Belanja::npsn($_SESSION['username'])->ta($_SESSION['ta']);
    $belanjasampaitw2= $belanja->sampaiTriwulan(2)->get()->sum('nilai');
    $paguperubahan= PaguPerubahan::npsn($npsn)->ta($ta)->first();
    $pagu= $paguperubahan->pagu;
    $rkaperubahan= Rka::npsn($npsn)->ta($ta)->where('jenis_rka','RKA Perubahan');
    $rkaperubahansampaitw3= $rkaperubahan->sampaiTriwulan(3)->get()->sum('nilai');
    $rkaperubahansampaitw4= $rkaperubahan->sampaiTriwulan(4)->get()->sum('nilai');

    $jatahtw3= $pagu*(80/100);
    $jatahtw4= $pagu*(100/100);
    $sisapagu3= $jatahtw3-$belanjasampaitw2-$rkaperubahansampaitw3;
    $sisapagu4= $jatahtw4-$belanjasampaitw2-$rkaperubahansampaitw4;
    
	// echo json_encode($pagu->sisa()->first());
	$tw="sisapagu";
	$totalsementara=0;
	for ($i=0; $i < $request->totalbaris ; $i++) { 
		$sisa= $tw.$request->triwulan;
		$totalsementara += $request->nilai[$i];
		if ($totalsementara <= $$sisa) {
			$datarka[$i] = new Rka([
				'ta' => $request->ta,
				'npsn' => $request->npsn,
				'triwulan' => $request->triwulan,
				'uraian' => $request->uraian[$i],
				'program_id' => $request->idprogram[$i],
				'pembiayaan_id' => $request->idkp[$i],
				'rekening_id' => $request->idrekening[$i],
				'nilai' => $request->nilai[$i],
				'jenis_rka' => 'RKA Perubahan',
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
			
			$sisapaguperubahan=$paguperubahan->sisa;
			$paguperubahan->sisa= $sisapaguperubahan - collect($simpanrkas)->sum('nilai');
			$paguperubahan->save();
		}
		
		
		// $jumlahrka =$simpanrkas->count();
		// foreach ($simpanrkas as $key => $value) {
		// for ($i=0; $i < $jumlahrka ; $i++) { 
		// 	# code...
		// 	$simpanrkas->sisas()->create([
		// 	    'nilai' => $simpanrkas->nilai,
		// 	]);
		// }
		// }
// echo $triwulan;

		// echo json_encode($sisapagu);
		// if ($simpanrkas) {
			header('location: /rkaperubahan.php');
		// }
	
	}
	else{
		echo "<script>alert(\"Maaf Pagu tidak cukup\"); window.location.href=\"/rkaperubahan.php\";</script>";
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