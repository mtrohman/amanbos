<?php

use Illuminate\Database\Capsule\Manager as DB;
use App\Models\Pengumuman;


include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

$id= $_GET['id'];

$ps= Pengumuman::find($id);
// $bpcount= count($bp);

$result= $ps;

// echo json_encode($result);
echo $result->konten;