<?php
include_once 'config/db.php';
include_once 'ceklogin.php';
require_once 'config/dbmanager.php';

if (!empty($_POST)) {
    $request= (object)$_POST;
    echo json_encode($request);
}
?>