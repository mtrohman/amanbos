<?php
use App\Models\Sekolah;
use App\Models\Saldo;
use App\Models\Belanjathlalu;

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
    $saldo = Saldo::ta($ta-1)->npsn($npsn)->first();
    if ($request->nilai <= $saldo->sisa) {
    	# code...
    	$belanja = array(
    		'ta' => $ta,
    		'triwulan' => $triwulan,
    		'program_id' => $request->program,
    		'pembiayaan_id' => $request->kp,
    		'rekening_id' => $request->rekening,
    		'nama' => $request->nama,
    		'nilai' => $request->nilai,
    		'tanggal_belanja' => $tanggalbelanja
    	);
    	$saldo->sisa -= $request->nilai;
    	$bljthlalu= $sekolah->belanjathlalus()->create($belanja);
    	if ($bljthlalu) {
    		# code...
	    	if($saldo->save()){
    			echo json_encode(array('success'=> true,'request' => $request,'saldo'=>$saldo));
	    	}
    	}
    	else{
    		echo json_encode(array('errorMsg'=>'Some errors occured. Belanja Tahun Lalu Gagal disimpan!'));
    	}
    }
    else{
    	echo json_encode(array('errorMsg'=>'Some errors occured. Saldo Tahun Lalu Tidak Cukup!'));
    }
    
}
?>