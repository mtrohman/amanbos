<?php
use App\Models\Pencairan;
use App\Models\Saldo;

include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

if (!empty($_POST)) {
    $request        = (object) $_POST;
    $id             = $request->id;
    $pencairan_lama = Pencairan::find($id);
    if (!empty($pencairan_lama)) {
        # code...
        // $sisa = $pencairan_lama->sisa()->delete();
        // if($sisa){
        // $sukses= $pencairan_lama->delete();
        // }
        $nilaipencairan = $pencairan_lama->saldo;
        $sisasaldo      = Saldo::where([
            'ta'   => $pencairan_lama->ta,
            'npsn' => $pencairan_lama->npsn,
        ])->first();
        $sisasaldo->sisa -= $nilaipencairan;
        if ($sisasaldo->save()) {
        	if ($pencairan_lama->delete()) {
	            echo json_encode(array('success' => true));
	        } else {
	            echo json_encode(array('errorMsg' => 'Some errors occured. 500'));
	        }
        }
        else{
        	echo json_encode(array('errorMsg' => 'Some errors occured. 503'));
        }

        // if ($sukses){
        //     echo json_encode(array('success'=>true));
        // } else {
        //     echo json_encode(array('errorMsg'=>'Some errors occured.'));
        // }
    } else {
        echo json_encode(array('errorMsg' => 'Some errors occured. 404'));
    }
}
