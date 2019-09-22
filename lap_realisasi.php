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

// Lap Realisasi
$npsn= $_SESSION['username'];
$ta= $_GET['ta'];
$tahun_tahun= "TAHUN ".$ta;
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


$total_rkaberjalan= Rka::with('rekening')->ta($ta)->thBerjalan()->npsn($npsn)->sum('nilai');

$rka_rek1= Rka::with('rekening')->ta($ta)->thBerjalan()->npsn($npsn)->parentRekening(1)->get()->sum('nilai');
$rka_rek2= Rka::with('rekening')->ta($ta)->thBerjalan()->npsn($npsn)->parentRekening(2)->get()->sum('nilai');
$rka_rek3= Rka::with('rekening')->ta($ta)->thBerjalan()->npsn($npsn)->parentRekening(3)->get()->sum('nilai');
$rka_rek4= Rka::with('rekening')->ta($ta)->thBerjalan()->npsn($npsn)->parentRekening(4)->get()->sum('nilai');
$rka_rek5= Rka::with('rekening')->ta($ta)->thBerjalan()->npsn($npsn)->parentRekening(5)->get()->sum('nilai');
// $rka_rek345= $rka_rek3+$rka_rek4+$rka_rek5;
// echo $rka_rek345;

$belanjar1_sd_twlalu= Belanja::npsn($npsn)->ta($ta)->sampaiTriwulan($triwulan-1)->with('rka.rekening')->parentRekening(1)->get()->sum('nilai');
$belanjar2_sd_twlalu= Belanja::npsn($npsn)->ta($ta)->sampaiTriwulan($triwulan-1)->with('rka.rekening')->parentRekening(2)->get()->sum('nilai');
$belanjar3_sd_twlalu= Belanja::npsn($npsn)->ta($ta)->sampaiTriwulan($triwulan-1)->with('rka.rekening')->parentRekening(3)->get()->sum('nilai');
$belanjar4_sd_twlalu= Belanja::npsn($npsn)->ta($ta)->sampaiTriwulan($triwulan-1)->with('rka.rekening')->parentRekening(4)->get()->sum('nilai');
$belanjar5_sd_twlalu= Belanja::npsn($npsn)->ta($ta)->sampaiTriwulan($triwulan-1)->with('rka.rekening')->parentRekening(5)->get()->sum('nilai');
// echo $belanjar4_sd_twlalu;

$belanjar1= Belanja::npsn($npsn)->ta($ta)->triwulan($triwulan)->with('rka.rekening')->parentRekening(1)->get()->sum('nilai');
$belanjar2= Belanja::npsn($npsn)->ta($ta)->triwulan($triwulan)->with('rka.rekening')->parentRekening(2)->get()->sum('nilai');
$belanjar3= Belanja::npsn($npsn)->ta($ta)->triwulan($triwulan)->with('rka.rekening')->parentRekening(3)->get()->sum('nilai');
$belanjar4= Belanja::npsn($npsn)->ta($ta)->triwulan($triwulan)->with('rka.rekening')->parentRekening(4)->get()->sum('nilai');
$belanjar5= Belanja::npsn($npsn)->ta($ta)->triwulan($triwulan)->with('rka.rekening')->parentRekening(5)->get()->sum('nilai');

$tanggal=date("Y-m-d");
$tanggal_tempat= "Kab. Semarang, ".tgl_indo($tanggal);
// echo $tanggal_tempat;
$sekolah= Sekolah::npsn($npsn)->first();
$nama_sekolah= $sekolah->nama_sekolah;
$nama_kepsek= $sekolah->nama_kepsek;
$nip_kepsek= $sekolah->nip_kepsek;

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('format/lap_realisasi.xlsx');

$worksheet = $spreadsheet->getActiveSheet();

$worksheet->getCell('tahun_tahun')->setValue($tahun_tahun);
$worksheet->getCell('deskripsi')->setValue($deskripsi);
$worksheet->getCell('total_rkaberjalan')->setValue($total_rkaberjalan);

$worksheet->getCell('rka_rek1')->setValue($rka_rek1);
$worksheet->getCell('rka_rek2')->setValue($rka_rek2);
$worksheet->getCell('rka_rek3')->setValue($rka_rek3);
$worksheet->getCell('rka_rek4')->setValue($rka_rek4);
$worksheet->getCell('rka_rek5')->setValue($rka_rek5);

$worksheet->getCell('belanjar1_sd_twlalu')->setValue($belanjar1_sd_twlalu);
$worksheet->getCell('belanjar2_sd_twlalu')->setValue($belanjar2_sd_twlalu);
$worksheet->getCell('belanjar3_sd_twlalu')->setValue($belanjar3_sd_twlalu);
$worksheet->getCell('belanjar4_sd_twlalu')->setValue($belanjar4_sd_twlalu);
$worksheet->getCell('belanjar5_sd_twlalu')->setValue($belanjar5_sd_twlalu);

$worksheet->getCell('belanjar1')->setValue($belanjar1);
$worksheet->getCell('belanjar2')->setValue($belanjar2);
$worksheet->getCell('belanjar3')->setValue($belanjar3);
$worksheet->getCell('belanjar4')->setValue($belanjar4);
$worksheet->getCell('belanjar5')->setValue($belanjar5);

$worksheet->getCell('tanggal_tempat')->setValue($tanggal_tempat);
$worksheet->getCell('nama_sekolah')->setValue($nama_sekolah);
$worksheet->getCell('nama_kepsek')->setValue($nama_kepsek);
$worksheet->getCell('nip_kepsek')->setValue("NIP.".$nip_kepsek);

// // $worksheet->getCell('A2')->setValue('Smith');

// $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
// $writer->save('output.xlsx');

$spreadsheet->getActiveSheet()
    ->getProtection()->setPassword('K8');
$spreadsheet->getActiveSheet()
    ->getProtection()->setSheet(true);
$spreadsheet->getActiveSheet()
    ->getProtection()->setFormatCells(true);

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$temp_file = tempnam(sys_get_temp_dir(), 'Excel');
$writer->save($temp_file);
$file= 'lap_realisasi_'.$ta.'_tw'.$triwulan.'_'.$npsn.'.xlsx';
$documento = file_get_contents($temp_file);
unlink($temp_file);  // delete file tmp
header("Content-Disposition: attachment; filename= ".$file."");
header('Content-Type: application/excel');
echo $documento;

