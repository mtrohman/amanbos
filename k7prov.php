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
use App\Models\KodeProgram;
use App\Models\KodePembiayaan;
use App\Models\Pencairan;

// Lap Realisasi
$npsn= $_SESSION['username'];
$ta= $_GET['ta'];
// $tahun_tahun= "TAHUN ".$ta;
$triwulan= $_GET['tw'];
$triwulan1= [1 ,2 ,3 ];
$triwulan2= [4 ,5 ,6 ];
$triwulan3= [7 ,8 ,9 ];
$triwulan4= [10,11,12];
$akhirtanggal = ($triwulan==1||$triwulan==4) ? 31 : ($triwulan==2||$triwulan==3) ? 30 : 0 ;
$bulanawal = ${"triwulan".$triwulan};
$periode="PERIODE TANGGAL : 1 ".bln_indo($bulanawal[0])." ".$ta." s/d ".$akhirtanggal." ".bln_indo($bulanawal[2])." ".$ta." (Triwulan ".$triwulan." Tahun ".$ta.")";
// echo json_encode($periode);

$sekolah= Sekolah::npsn($npsn)->first();
$nama_sekolah= $sekolah->nama_sekolah;
$nama_kepsek= $sekolah->nama_kepsek;
$nip_kepsek= $sekolah->nip_kepsek;
$nama_bendahara= $sekolah->nama_bendahara;
$nip_bendahara= $sekolah->nip_bendahara;
$nama_kecamatan= $sekolah->kecamatannya->nama_kecamatan;
$saldo_tw_lalu=0;
$penerimaan_tw_sekarang= Pencairan::npsn($npsn)->ta($ta)->triwulan($triwulan)->get()->sum('saldo');
$teks_saldo_tw= ($triwulan==1)? "-" : "Saldo TW".$triwulan;
$teks_penerimaan_tw= "Penerimaan TW".$triwulan;
$teks_sisa_tw= "Sisa Akhir Triwulan ".$triwulan;

$program= KodeProgram::all();
$pembiayaan= KodePembiayaan::all();
$program_kp= array();
foreach ($program as $key => $p) {
	foreach ($pembiayaan as $kpkey => $kp) {
		$program_kp_detail= Belanja::with('rka')->npsn($npsn)->ta($ta)->triwulan($triwulan)->idProgram($p->id)->idKp($kp->id)->get()->sum('nilai');
		$program_kp[$p->id][$kp->id]=$program_kp_detail;
	}
}
// echo json_encode($program_kp);


$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('format/k7_prov1.xlsx');

$worksheet = $spreadsheet->getActiveSheet();

$worksheet->getCell('periode')->setValue($periode);
$worksheet->getCell('nama_sekolah')->setValue($nama_sekolah);
$worksheet->getCell('nama_kecamatan')->setValue($nama_kecamatan);
$worksheet->getCell('nama_kepsek')->setValue($nama_kepsek);
$worksheet->getCell('nip_kepsek')->setValue("NIP.".$nip_kepsek);
$worksheet->getCell('nama_bendahara')->setValue($nama_bendahara);
$worksheet->getCell('nip_bendahara')->setValue("NIP.".$nip_bendahara);
$worksheet->getCell('teks_saldo_tw')->setValue($teks_saldo_tw);
$worksheet->getCell('saldo_tw_lalu')->setValue($saldo_tw_lalu);
$worksheet->getCell('teks_penerimaan_tw')->setValue($teks_penerimaan_tw);
$worksheet->getCell('penerimaan_tw_sekarang')->setValue($penerimaan_tw_sekarang);

$worksheet->fromArray(
    $program_kp,
    null,
    'E16'
);


// $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
// $writer->save('output.xlsx');

$spreadsheet->getActiveSheet()
    ->getProtection()->setPassword('K8');
$spreadsheet->getActiveSheet()
    ->getProtection()->setSheet(true);
$spreadsheet->getActiveSheet()
    ->getProtection()->setFormatCells(false);

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$temp_file = tempnam(sys_get_temp_dir(), 'Excel');
$writer->save($temp_file);
$file= 'k7prov_'.$ta.'_tw'.$triwulan.'_'.$npsn.'.xlsx';
$documento = file_get_contents($temp_file);
unlink($temp_file);  // delete file tmp
header("Content-Disposition: attachment; filename= ".$file."");
header('Content-Type: application/excel');
echo $documento;