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
$npsn= $_POST['npsn'];
$ta= $_POST['ta'];
// $tahun_tahun= "TAHUN ".$ta;
$nomor_sptmh= $_POST['nomor_sptmh'];
$triwulan= $_POST['tw'];
$triwulan1= [1 ,2 ,3 ];
$triwulan2= [4 ,5 ,6 ];
$triwulan3= [7 ,8 ,9 ];
$triwulan4= [10,11,12];
$akhirtanggal = ($triwulan==1||$triwulan==4) ? 31 : ($triwulan==2||$triwulan==3) ? 30 : 0 ;
$bulanawal = ${"triwulan".$triwulan};

$tanggal= $akhirtanggal." ".bln_indo($bulanawal[2])." ".$ta;
$tanggal_tanggal= strtoupper("Tanggal ".$tanggal);

$sekolah= Sekolah::npsn($npsn)->first();
$nama_sekolah= $sekolah->nama_sekolah;
$nama_kepsek= $sekolah->nama_kepsek;
$nip_kepsek= $sekolah->nip_kepsek;
$jenjang= $sekolah->jenjang;
$nama_kecamatan= $sekolah->kecamatannya->nama_kecamatan;
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

$deskripsi= "Bertangungjawab penuh atas segala penerima hibah berupa uang yang diterima langsung pada triwulan ".$twhuruf;


$total_rka_berjalan= Rka::with('rekening')->ta($ta)->thBerjalan()->npsn($npsn)->sum('nilai');
$total_rka= $total_rka_berjalan;

// $belanjar1_sd_twlalu= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->sampaiTriwulan($triwulan-1)->with('rka.rekening')->parentRekening(1)->get()->sum('nilai');
// $belanjar2_sd_twlalu= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->sampaiTriwulan($triwulan-1)->with('rka.rekening')->parentRekening(2)->get()->sum('nilai');
// $belanjar3_sd_twlalu= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->sampaiTriwulan($triwulan-1)->with('rka.rekening')->parentRekening(3)->get()->sum('nilai');
// $belanjar4_sd_twlalu= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->sampaiTriwulan($triwulan-1)->with('rka.rekening')->parentRekening(4)->get()->sum('nilai');
// $belanjar5_sd_twlalu= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->sampaiTriwulan($triwulan-1)->with('rka.rekening')->parentRekening(5)->get()->sum('nilai');
// $realisasi_sd_twlalu= $belanjar1_sd_twlalu+$belanjar2_sd_twlalu+$belanjar3_sd_twlalu+$belanjar4_sd_twlalu+$belanjar5_sd_twlalu;
$realisasi_sd_twlalu= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->sampaiTriwulan($triwulan-1)->with('rka')->get()->sum('nilai');
// echo $belanjar4_sd_twlalu;

// $belanjar1= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->triwulan($triwulan)->with('rka.rekening')->parentRekening(1)->get()->sum('nilai');
// $belanjar2= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->triwulan($triwulan)->with('rka.rekening')->parentRekening(2)->get()->sum('nilai');
// $belanjar3= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->triwulan($triwulan)->with('rka.rekening')->parentRekening(3)->get()->sum('nilai');
// $belanjar4= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->triwulan($triwulan)->with('rka.rekening')->parentRekening(4)->get()->sum('nilai');
// $belanjar5= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->triwulan($triwulan)->with('rka.rekening')->parentRekening(5)->get()->sum('nilai');
$realisasi_twsekarang= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->triwulan($triwulan)->with('rka')->get()->sum('nilai');
$tanggal_tempat= "Kab. Semarang, ".$tanggal;

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('format/sptmh.xlsx');

$worksheet = $spreadsheet->getActiveSheet();

$worksheet->getCell('nomor_sptmh')->setValue($nomor_sptmh);
$worksheet->getCell('tanggal_tanggal')->setValue($tanggal_tanggal);
$worksheet->getCell('jenjang')->setValue($jenjang);
$worksheet->getCell('nama_sekolah')->setValue($nama_sekolah);
$worksheet->getCell('nama_kecamatan')->setValue($nama_kecamatan);
$worksheet->getCell('npsn')->setValue($npsn);
$worksheet->getCell('deskripsi')->setValue($deskripsi);
$worksheet->getCell('total_rka')->setValue($total_rka);
$worksheet->getCell('realisasi_sd_twlalu')->setValue($realisasi_sd_twlalu);
$worksheet->getCell('realisasi_twsekarang')->setValue($realisasi_twsekarang);
$worksheet->getCell('tanggal_tempat')->setValue($tanggal_tempat);
$worksheet->getCell('nama_kepsek')->setValue($nama_kepsek);
$worksheet->getCell('nip_kepsek')->setValue('NIP.'.$nip_kepsek);

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
$file= 'sptmh_'.$ta.'_tw'.$triwulan.'_'.$npsn.'.xlsx';
$documento = file_get_contents($temp_file);
unlink($temp_file);  // delete file tmp
header("Content-Disposition: attachment; filename= ".$file."");
header('Content-Type: application/excel');
echo $documento;