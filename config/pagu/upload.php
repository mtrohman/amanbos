<?php
$dir_root= $_SERVER['DOCUMENT_ROOT']."";
include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
$gagal=0;
$sukses=0;
$pesan="";


$ta   = htmlspecialchars($_REQUEST['ta']);
$file = $_FILES['file']['name'];

$targetPath = 'upload/pagu/' . $_FILES['file']['name'];
$FileType   = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));

if ($FileType == "xlsx") {
    # code...
    $sukses=move_uploaded_file($_FILES['file']['tmp_name'], $dir_root . "/" . $targetPath);
}

echo <<<INFO
<div style="padding:0 50px">
<p>$pesan</p>
</div>
INFO;
