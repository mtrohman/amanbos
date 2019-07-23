<?php
$dir_root= $_SERVER['DOCUMENT_ROOT']."";
include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Models\Pagu;

$jumlahsukses=0;
$sukses=array();
$pesan="";


$ta   = htmlspecialchars($_REQUEST['ta']);
$file = $_FILES['file']['name'];

$targetPath = 'upload/pagu/' . $_FILES['file']['name'];
$FileType   = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));

if ($FileType == "xlsx") {
    # code...
    move_uploaded_file($_FILES['file']['tmp_name'], $dir_root . "/" . $targetPath);
    $reader = new Xlsx();
    $spreadsheet = $reader->load($dir_root . "/" . $targetPath);
    $worksheet = $spreadsheet->getActiveSheet();
    $highestRow = $worksheet->getHighestRow(); // e.g. 10
    $highestColumnIndex=4;
    for ($row = 2; $row <= $highestRow; ++$row) {
    	$npsn= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
    	$pagu= $worksheet->getCellByColumnAndRow(4, $row)->getValue();
		$tw1= (20/100)*$pagu;
		$tw2= (40/100)*$pagu;
		$tw3= (20/100)*$pagu;
		$tw4= (20/100)*$pagu;

		// $sukses=false;
		$pagu_baru = Pagu::updateOrCreate(
			['ta' => $ta, 'npsn' => $npsn],
			[
				'pagu' => $pagu,
				'tw1' => $tw1,
				'tw2' => $tw2,
				'tw3' => $tw3,
				'tw4' => $tw4
			]
		);

		if($pagu_baru){
			$sisa_pagu= $pagu_baru->sisa()->updateOrCreate(
			['pagu_id'=>$pagu_baru->id],
			[
				'tw1' => $tw1,
				'tw2' => $tw2,
				'tw3' => $tw3,
				'tw4' => $tw4,
			]);
			$sukses[($row-1)] = ($sisa_pagu) ? true : false;
			if($sukses[($row-1)]) $jumlahsukses++;
			else $pesan .= "data ke ".($row-1)." tidak tersimpan\n";
		}

		
    }
    $pesan .= $jumlahsukses." data berhasil disimpan";
    echo json_encode(array('success'=>'true','pesan'=>$pesan));
}
else{
	$pesan="Extensi File tidak sesuai";
	echo json_encode(array('errorMsg'=>$pesan));
}

// echo <<<INFO
// <div style="padding:0 50px">
// <p>$pesan</p>
// </div>
// INFO;

