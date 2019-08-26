<?php
use App\Models\Sekolah;
// use App\Models\Belanja;

// use App\Models\Rka;
header('Content-Type: application/json');

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';
$ta= $_SESSION['ta'];
$npsn = (!empty($_POST['npsn'])) ? $_POST['npsn'] : ($_SESSION['role']=="2") ? $_SESSION['username'] : '' ;
// $triwulan= (!empty($_POST['triwulan'])) ? $_POST['triwulan'] : (!empty($_SESSION['triwulan'])) ? $_SESSION['triwulan'] : '' ;
// $triwulan=1;



	
if (!empty($_POST)) {
    $request = (object)$_POST;
    // echo(json_encode($request));
    $triwulan= (!empty($_POST['triwulan'])) ? $_POST['triwulan'] : triwulan($request->tanggal_belanja);

    $tanggalbelanja= DateTime::createFromFormat('d-m-Y', $request->tanggal_belanja);

    $sekolah= Sekolah::npsn($npsn)->first();
    $rka=$sekolah->rkas()->with(['sisa'])->where('id',$request->rka_id)->first();
    // $saldo=$sekolah->pencairans()->with(['sisa'])->triwulan($triwulan)->ta($ta)->first();
    $saldo= $sekolah->saldos()->where('ta',$ta)->first();
    
    if ($request->nilai <= $rka->sisa->nilai) {
    	if ($request->nilai <= $saldo->sisa) {
    		$tambahbelanja= $rka->belanja()->create([
    			'triwulan' => $triwulan,
			    'rka_id' => $request->rka_id,
			    'nama' => $request->nama,
			    'nilai' => $request->nilai,
			    'tanggal_belanja' => $tanggalbelanja,
			    
			]);
			if ($tambahbelanja) {
				$rka->sisa->nilai -= $request->nilai;
				$saldo->sisa -= $request->nilai;
				if ($rka->push() && $saldo->save()) {
					# code...
					echo json_encode(array('success'=> true,'request' => $request,'saldo'=>$saldo,'rka'=>$rka));
				} else {
					echo json_encode(array('errorMsg'=>'Some errors occured. #01'));
				}
				
			} else {
				echo json_encode(array('errorMsg'=>'Some errors occured. #02'));
			}
			
    	} else {
    		echo json_encode(array('errorMsg'=>'Some errors occured. #Saldo Tidak Cukup','saldo'=>$saldo));
    	}
    	
    } else {
    	echo json_encode(array('errorMsg'=>'Some errors occured. #RKA Tidak Cukup'));
    }
    


    // echo json_encode($rka);
	// end
	// if ($sekolah->rkas()->saveMany($datarka)){	
		// echo ;
		// header('location: /rka.php');
	// } else {
    // ,'saldo'=>$saldo,'rka'=>$rka
    // 'errorMsg'=>'Some errors occured.',
		
	// }
}
?>