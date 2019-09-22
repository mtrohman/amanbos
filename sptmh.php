<?php
require 'vendor/autoload.php';
include_once 'config/db.php';
require_once 'config/dbmanager.php';
// include_once 'ceklogin.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Sekolah;
use App\Models\Rka;

// Lap Realisasi
$npsn= $_SESSION['username'];
// $ta= $_GET['ta'];
// $tahun_tahun= "TAHUN ".$ta;
$triwulan= $_GET['tw'];
switch ($triwulan) {
	case '1':
		# code...
		$twhuruf= "I";
		break;
	case '2':
		# code...
		$twhuruf= "II";
		break;
	case '3':
		# code...
		$twhuruf= "III";
		break;
	case '4':
		# code...
		$twhuruf= "IV";
		break;
	
	default:
		# code...
		$twhuruf="-";
		break;
}

$deskripsi= "Bersama ini kami laporkan realisasi atas penggunaan Dana BOS untuk Triwulan ".$twhuruf."  sebagai berikut:";


$total_rka_berjalan= Rka::with('rekening')->ta($ta)->thBerjalan()->npsn($npsn)->sum('nilai');




// $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('bukti_pengeluaran.xlsx');

// $worksheet = $spreadsheet->getActiveSheet();

// $worksheet->getCell('nama_kepalasekolah')->setValue('John');
// // $worksheet->getCell('A2')->setValue('Smith');

// $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
// $writer->save('output.xlsx');

