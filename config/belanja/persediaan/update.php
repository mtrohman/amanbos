<?php
use App\Models\BelanjaPersediaan;

// use App\Models\Rka;
header('Content-Type: application/json');

include_once '../../db.php';
// include_once '../../ceklogin.php';
require_once '../../dbmanager.php';


if (!empty($_POST)) {
    $request    = (object) $_POST;
    $persediaan = $_GET['persediaan'];

    $belanjapersediaan                  = BelanjaPersediaan::find($persediaan);
    $belanjapersediaan->nama_persediaan = $request->nama_persediaan;
    $belanjapersediaan->satuan          = $request->satuan;
    $belanjapersediaan->harga_satuan    = $request->harga_satuan;
    $belanjapersediaan->qty             = $request->qty;
    $belanjapersediaan->total           = $request->total;
    $save                               = $belanjapersediaan->save();
    if ($save) {
        echo json_encode(array('success' => true, 'request' => $request, 'belanjapersediaan' => $belanjapersediaan));
    } else {
        echo json_encode(array(
            'errorMsg' => 'Oops ada yang error.',
            'request'  => $request,
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
