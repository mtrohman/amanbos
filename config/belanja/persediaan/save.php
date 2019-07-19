<?php
use App\Models\Sekolah;
use App\Models\Belanja;
use App\Models\BelanjaPersediaan;

// use App\Models\Rka;
header('Content-Type: application/json');

include_once '../../db.php';
// include_once '../../ceklogin.php';
require_once '../../dbmanager.php';
// $npsn = (!empty($_POST['npsn'])) ? $_POST['npsn'] : ($_SESSION['role']=="2") ? $_SESSION['username'] : '' ;
// $triwulan= (!empty($_POST['triwulan'])) ? $_POST['triwulan'] : (!empty($_SESSION['triwulan'])) ? $_SESSION['triwulan'] : '' ;
// $triwulan=1;
	
if (!empty($_POST)) {
    $request = (object)$_POST;
    $id= $_GET['id'];
    // echo(json_encode($request));
   //  $tanggalbelanja= DateTime::createFromFormat('d-m-Y', $request->tanggal_belanja);

   //  $sekolah= Sekolah::npsn($npsn)->first();
   //  $rka=$sekolah->rkas()->with(['sisa'])->where('id',$request->rka_id)->first();
   //  $saldo=$sekolah->pencairans()->with(['sisa'])->triwulan($triwulan)->ta($ta)->first();
    
   //  if ($request->nilai <= $rka->sisa->nilai) {
   //  	if ($request->nilai <= $saldo->sisa->saldo) {
   //  		$tambahbelanja= $rka->belanja()->create([
   //  			'triwulan' => $triwulan,
			//     'rka_id' => $request->rka_id,
			//     'nama' => $request->nama,
			//     'nilai' => $request->nilai,
			//     'tanggal_belanja' => $tanggalbelanja,
			    
			// ]);
			// if ($tambahbelanja) {
			// 	$rka->sisa->nilai -= $request->nilai;
			// 	$saldo->sisa->saldo -= $request->nilai;
			// 	if ($rka->push() && $saldo->push()) {
			// 		# code...
			// 		echo json_encode(array('success'=> true,'request' => $request,'saldo'=>$saldo,'rka'=>$rka));
			// 	} else {
			// 		echo json_encode(array('errorMsg'=>'Some errors occured. #01'));
			// 	}
				
			// } else {
			// 	echo json_encode(array('errorMsg'=>'Some errors occured. #02'));
			// }
			
   //  	} else {
   //  		echo json_encode(array('errorMsg'=>'Some errors occured. #Saldo Tidak Cukup'));
   //  	}
    	
   //  } else {
    	// echo json_encode(array('errorMsg'=>'Some errors occured. #RKA Tidak Cukup'));
   //  }
    $belanja= Belanja::find($id);
    $persediaan = new BelanjaPersediaan([
    	'nama_persediaan' => $request->nama_persediaan,
    	'satuan' => $request->satuan,
    	'harga_satuan' => $request->harga_satuan,
    	'qty' => $request->qty,
    	'total' => $request->total,
    ]);
    $save= $belanja->belanja_persediaan()->save($persediaan);
    if ($save) {
    	echo json_encode(array('success'=> true,'request' => $request,'persediaan'=>$persediaan,'belanja'=>$belanja));
    }
    else{
	    echo json_encode(array(
	    	'errorMsg'=>'Oops ada yang error.',
	    	'request'=>$request,
	    ));
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