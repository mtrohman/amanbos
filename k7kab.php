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
use App\Models\KodeRekening;
use App\Models\Pencairan;

// Lap Realisasi
$npsn= $_SESSION['username'];
$ta= $_GET['ta'];
// $tahun_tahun= "TAHUN ".$ta;
$triwulan= $_GET['tw'];
$judul= "REKAPITULASI PENGGUNAAN DANA BOS TRIWULAN ".$triwulan." TAHUN ".$ta;
$sekolah= Sekolah::npsn($npsn)->first();
$nama_sekolah= $sekolah->nama_sekolah;
$nama_kepsek= $sekolah->nama_kepsek;
$nip_kepsek= $sekolah->nip_kepsek;
$nama_bendahara= $sekolah->nama_bendahara;
$nip_bendahara= $sekolah->nip_bendahara;
$nama_kecamatan= $sekolah->kecamatannya->nama_kecamatan;
$saldo_twlalu=0;
// $penerimaan_twsekarang=0;
$penerimaan_twsekarang= Pencairan::npsn($npsn)->ta($ta)->triwulan($triwulan)->get()->sum('saldo');
$saldo_tw= ($triwulan==1)? "-" : "Saldo TW".$triwulan;
$penerimaan_tw= "Penerimaan TW".$triwulan;

$triwulan1= [1 ,2 ,3 ];
$triwulan2= [4 ,5 ,6 ];
$triwulan3= [7 ,8 ,9 ];
$triwulan4= [10,11,12];
// $twarray= "triwulan".$triwulan;
$bulanawal = ${"triwulan".$triwulan};

$bulan1= bln_indo($bulanawal[0]);
$bulan2= bln_indo($bulanawal[1]);
$bulan3= bln_indo($bulanawal[2]);
$nama_triwulan= "Triwulan ".$triwulan;

// whereIn('parent_id', [3, 4, 5])
// where('parent_id',1)
$rekening1= KodeRekening::where('parent_id',1)->get();
$belanjar1= array();
foreach ($rekening1 as $key => $rek1) {
	// $belanjar1[$rek1->id]=$key;
	foreach ($bulanawal as $twkey => $bulan) {
		$belanjar1detail= Belanja::npsn($npsn)->ta($ta)->triwulan($triwulan)->idRekening($rek1->id)->whereMonth('tanggal_belanja',$bulan)->get()->sum('nilai');
		$belanjar1[$rek1->id][$bulan]=$belanjar1detail;
	}
}
// echo json_encode($belanjar1);

// whereIn('parent_id', [3, 4, 5])
// where('parent_id',1)
$rekening2= KodeRekening::where('parent_id',2)->get();
$belanjar2= array();
foreach ($rekening2 as $key => $rek2) {
	// $belanjar1[$rek1->id]=$key;
	foreach ($bulanawal as $twkey => $bulan) {
		$belanjar2detail= Belanja::npsn($npsn)->ta($ta)->triwulan($triwulan)->idRekening($rek2->id)->whereMonth('tanggal_belanja',$bulan)->get()->sum('nilai');
		$belanjar2[$rek2->id][$bulan]=$belanjar2detail;
	}
}
// echo json_encode($belanjar2);

// whereIn('parent_id', [3, 4, 5])
// where('parent_id',1)
$rekening3= KodeRekening::whereIn('parent_id', [3, 4, 5])->get();
$belanjar3= array();
foreach ($rekening3 as $key => $rek3) {
	// $belanjar1[$rek1->id]=$key;
	foreach ($bulanawal as $twkey => $bulan) {
		$belanjar3detail= Belanja::npsn($npsn)->ta($ta)->triwulan($triwulan)->idRekening($rek3->id)->whereMonth('tanggal_belanja',$bulan)->get()->sum('nilai');
		$belanjar3[$rek3->id][$bulan]=$belanjar3detail;
	}
}
// echo json_encode($belanjar3);



// $tanggal_tempat= "Kab. Semarang, ".tgl_indo($tanggal);

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('format/k7_kab1.xlsx');

$worksheet = $spreadsheet->getActiveSheet();

$worksheet->getCell('judul')->setValue($judul);
$worksheet->getCell('npsn')->setValue($npsn);
$worksheet->getCell('nama_sekolah')->setValue($nama_sekolah);
$worksheet->getCell('nama_kecamatan')->setValue($nama_kecamatan);
$worksheet->getCell('saldo_tw')->setValue($saldo_tw);
$worksheet->getCell('saldo_twlalu')->setValue($saldo_twlalu);
$worksheet->getCell('penerimaan_tw')->setValue($penerimaan_tw);
$worksheet->getCell('penerimaan_twsekarang')->setValue($penerimaan_twsekarang);
$worksheet->getCell('bulan1')->setValue($bulan1);
$worksheet->getCell('bulan2')->setValue($bulan2);
$worksheet->getCell('bulan3')->setValue($bulan3);
$worksheet->getCell('nama_triwulan')->setValue($nama_triwulan);
$worksheet->getCell('nama_kepsek')->setValue($nama_kepsek);
$worksheet->getCell('nip_kepsek')->setValue("NIP.".$nip_kepsek);
$worksheet->getCell('nama_bendahara')->setValue($nama_bendahara);
$worksheet->getCell('nip_bendahara')->setValue("NIP.".$nip_bendahara);

$worksheet->fromArray(
    $belanjar1,
    null,
    'F11'
);
$worksheet->fromArray(
    $belanjar2,
    null,
    'F16'
);
$worksheet->fromArray(
    $belanjar3,
    null,
    'F62'
);


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
$file= 'k7kab_'.$ta.'_tw'.$triwulan.'_'.$npsn.'.xlsx';
$documento = file_get_contents($temp_file);
unlink($temp_file);  // delete file tmp
header("Content-Disposition: attachment; filename= ".$file."");
header('Content-Type: application/excel');
echo $documento;