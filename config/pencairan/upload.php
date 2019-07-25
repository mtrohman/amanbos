<?php
$dir_root= $_SERVER['DOCUMENT_ROOT']."";
include_once '../db.php';
// include_once '../../ceklogin.php';
require_once '../dbmanager.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Models\Pencairan;
use App\Models\Saldo;

$jumlahsukses=0;
$sukses=array();
$pesan="";


$ta   = htmlspecialchars($_REQUEST['ta']);
$triwulan   = htmlspecialchars($_REQUEST['triwulan']);
$file = $_FILES['file']['name'];

$targetPath = 'upload/pencairan/' . $_FILES['file']['name'];
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
    	$pencairan= $worksheet->getCellByColumnAndRow(4, $row)->getValue();

		$pencairan_baru= Pencairan::firstOrNew([
			'ta' => $ta,
			'npsn' => $npsn,
			'triwulan' => $triwulan
		]);

		$selisih[$row]=0;
		$pencairan_lama[$row]=false;
		if(!empty($pencairan_baru->saldo)){ //jika pencairan sudah ada sebelumnya maka cari selisihnya
			$pencairan_lama[$row]= true;
			$nilailama= $pencairan_baru->saldo;
			$nilaibaru= $pencairan;

			if ($nilaibaru != $nilailama) {
				$selisih[$row]= $nilaibaru-$nilailama;
			}
			
		}

		$pencairan_baru->saldo = $pencairan;
		if($pencairan_baru->save()){
			$saldo= Saldo::firstOrNew(
				[
					'ta' => $ta,
					'npsn' => $npsn
				]
			);
			
			if($pencairan_lama[$row]){//berarti pencairan sudah ada sebelumnya
				$saldo->sisa += $selisih[$row];
			}
			else{
				$saldo->sisa += $pencairan;
			}

			$sukses[($row-1)] = $saldo->save();
			if($sukses[($row-1)]) $jumlahsukses++;
			else $pesan .= "data ke ".($row-1)." tidak tersimpan\n";
		}

// 		if($pagu_baru){
// 			$sisa_pagu= $pagu_baru->sisa()->updateOrCreate(
// 			['pagu_id'=>$pagu_baru->id],
// 			[
// 				'tw1' => $tw1,
// 				'tw2' => $tw2,
// 				'tw3' => $tw3,
// 				'tw4' => $tw4,
// 			]);
// 			$sukses[($row-1)] = ($sisa_pagu) ? true : false;
// 			if($sukses[($row-1)]) $jumlahsukses++;
// 			else $pesan .= "data ke ".($row-1)." tidak tersimpan\n";
		// }
		
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

