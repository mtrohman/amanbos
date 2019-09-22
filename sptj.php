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
use App\Models\Belanja;
use App\Models\Saldo;
use App\Models\Pencairan;

// Lap Realisasi
$npsn= $_SESSION['username'];
$ta= $_GET['ta'];
$teks_saldo_tahun= "TAHUN ".($ta-1);
$triwulan= $_GET['tw'];
$nomor_sptj= $_GET['nomor_sptj'];
$sekolah= Sekolah::npsn($npsn)->first();
$nama_sekolah= $sekolah->nama_sekolah;
$jenjang= $sekolah->jenjang;

if ($triwulan==3 || $triwulan==4) {
	$semester="I";
}
elseif($triwulan==1 || $triwulan==2){
	$semester="II";
}

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

$paragraf_terakhir= "penggunaan Dana BOS pada semester ".$semester." dan triwulan ".$twhuruf." Tahun Anggaran ".$ta." dengan rincian sebagai berikut:";

$saldo_thlalu=Saldo::ta($ta-1)->npsn($npsn)->get()->sum('sisa');

$penerimaan_tw1= Pencairan::npsn($npsn)->ta($ta)->triwulan(1)->get()->sum('saldo');
$penerimaan_tw2= Pencairan::npsn($npsn)->ta($ta)->triwulan(2)->get()->sum('saldo');
$penerimaan_tw3= Pencairan::npsn($npsn)->ta($ta)->triwulan(3)->get()->sum('saldo');
$penerimaan_tw4= Pencairan::npsn($npsn)->ta($ta)->triwulan(4)->get()->sum('saldo');

$belanjar1_sd_tw_sekarang= Belanja::npsn($npsn)->ta($ta)->sampaiTriwulan($triwulan)->with('rka.rekening')->parentRekening(1)->get()->sum('nilai');
$belanjar2_sd_tw_sekarang= Belanja::npsn($npsn)->ta($ta)->sampaiTriwulan($triwulan)->with('rka.rekening')->parentRekening(2)->get()->sum('nilai');
$belanjar3_sd_tw_sekarang= Belanja::npsn($npsn)->ta($ta)->sampaiTriwulan($triwulan)->with('rka.rekening')->parentRekening(3)->get()->sum('nilai');
$belanjar4_sd_tw_sekarang= Belanja::npsn($npsn)->ta($ta)->sampaiTriwulan($triwulan)->with('rka.rekening')->parentRekening(4)->get()->sum('nilai');
$belanjar5_sd_tw_sekarang= Belanja::npsn($npsn)->ta($ta)->sampaiTriwulan($triwulan)->with('rka.rekening')->parentRekening(5)->get()->sum('nilai');
$belanjar345_sd_tw_sekarang= $belanjar3_sd_tw_sekarang+$belanjar4_sd_tw_sekarang+$belanjar5_sd_tw_sekarang;
// echo json_encode($belanjar345_sd_tw_sekarang);


// $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('bukti_pengeluaran.xlsx');

// $worksheet = $spreadsheet->getActiveSheet();

// $worksheet->getCell('nama_kepalasekolah')->setValue('John');
// // $worksheet->getCell('A2')->setValue('Smith');

// $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
// $writer->save('output.xlsx');

