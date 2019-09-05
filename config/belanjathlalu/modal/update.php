<?php
use App\Models\BelanjaModal;

// use App\Models\Rka;
header('Content-Type: application/json');

include_once '../../db.php';
// include_once '../../ceklogin.php';
require_once '../../dbmanager.php';

if (!empty($_POST)) {
    $request = (object) $_POST;
    $modal   = $_GET['modal'];

    $belanjamodal = BelanjaModal::find($modal);
    $belanjamodal->fill($_POST);
    if ($belanjamodal->save()) {
        echo json_encode(array('success' => true, 'request' => $request, 'belanjamodal' => $belanjamodal));
    } else {
        echo json_encode(array(
            'errorMsg' => 'Oops ada yang error.',
            'request'  => $request,
        ));
    }

}
