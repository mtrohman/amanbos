<?php

use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Belanjathlalu;
// use App\Models\Rka;


include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

$id= $_GET['id'];

$bp= Belanjathlalu::find($id)->belanja_persediaan;
// $bpcount= count($bp);

$result= $bp;

echo json_encode($result);
