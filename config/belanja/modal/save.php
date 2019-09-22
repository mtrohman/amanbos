<?php
use App\Models\Sekolah;
use App\Models\Belanja;
use App\Models\BelanjaPersediaan;

// use App\Models\Rka;
header('Content-Type: application/json');

include_once '../../db.php';
// include_once '../../ceklogin.php';
require_once '../../dbmanager.php';
	
if (!empty($_POST)) {
    $request = (object)$_POST;
    $id= $_GET['id'];
    
    $belanja= Belanja::find($id);
    $belanjamodal= $_POST;
    $belanjamodal['bukti_tanggal']=DateTime::createFromFormat('d-m-Y', $request->bukti_tanggal);
    
    $save= $belanja->belanja_modal()->create($belanjamodal);
    if ($save) {
    	echo json_encode(array('success'=> true,'request' => $request,'belanja'=>$belanja));
    }
    else{
	    echo json_encode(array(
	    	'errorMsg'=>'Oops ada yang error.',
	    	'request'=>$request,
	    ));
    }

}
?>