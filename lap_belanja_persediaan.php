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
// use App\Models\BelanjaModal;
use App\Models\BelanjaPersediaan;
use App\Models\KodeProgram;
use App\Models\KodePembiayaan;
use App\Models\Pencairan;

// Lap Realisasi
$npsn= $_POST['npsn'];
$ta= $_POST['ta'];
// $tahun_tahun= "TAHUN ".$ta;
$triwulan= $_POST['tw'];
$triwulan1= [1 ,2 ,3 ];
$triwulan2= [4 ,5 ,6 ];
$triwulan3= [7 ,8 ,9 ];
$triwulan4= [10,11,12];
$akhirtanggal = ($triwulan==1||$triwulan==4) ? 31 : ($triwulan==2||$triwulan==3) ? 30 : 0 ;
$bulanawal = ${"triwulan".$triwulan};
$tanggal= $akhirtanggal." ".bln_indo($bulanawal[2])." ".$ta;
$tanggal_tempat= "Kab. Semarang, ".$tanggal;

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
$triwulan_tahun="TRIWULAN ".$twhuruf." TAHUN ANGGARAN ".$ta;
// echo json_encode($periode);

$sekolah= Sekolah::npsn($npsn)->first();
$nama_sekolah= $sekolah->nama_sekolah;
$nama_kepsek= $sekolah->nama_kepsek;
$nip_kepsek= $sekolah->nip_kepsek;
$nama_bendahara= $sekolah->nama_bendahara;
$nip_bendahara= $sekolah->nip_bendahara;
$kecamatan= $sekolah->kecamatannya->nama_kecamatan;


$barang_persediaan= array();
$belanja_persediaan= BelanjaPersediaan::npsn($npsn)->triwulan($triwulan)->get();
foreach ($belanja_persediaan as $key => $persediaan) {
    $barang_persediaan[$key]['tanggal']= tgl_indo($persediaan->belanja->tanggal_belanja);
    $barang_persediaan[$key]['nama_barang']= $persediaan->nama_persediaan;
    $barang_persediaan[$key]['jenis']= (int)$persediaan->belanja->rka->rekening->kode_rekening;
    $barang_persediaan[$key]['qty']= $persediaan->qty;
    $barang_persediaan[$key]['satuan']= $persediaan->satuan;
    $barang_persediaan[$key]['harga_satuan']= $persediaan->harga_satuan;
       
}
// echo json_encode($barang_persediaan);


$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('format/belanja_persediaan.xlsx');

$worksheet = $spreadsheet->getActiveSheet();

$worksheet->getCell('triwulan_tahun')->setValue($triwulan_tahun);
$worksheet->getCell('nama_sekolah')->setValue($nama_sekolah);
$worksheet->getCell('kecamatan')->setValue($kecamatan);
$worksheet->getCell('tanggal_tempat')->setValue($tanggal_tempat);
$worksheet->getCell('nama_kepsek')->setValue($nama_kepsek);
$worksheet->getCell('nip_kepsek')->setValue("NIP.".$nip_kepsek);
$worksheet->getCell('nama_bendahara')->setValue($nama_bendahara);
$worksheet->getCell('nip_bendahara')->setValue("NIP.".$nip_bendahara);

$worksheet->fromArray(
    $barang_persediaan,
    null,
    'B10'
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
$file= 'b_persediaan_'.$ta.'_tw'.$triwulan.'_'.$npsn.'.xlsx';
$documento = file_get_contents($temp_file);
unlink($temp_file);  // delete file tmp
header("Content-Disposition: attachment; filename= ".$file."");
header('Content-Type: application/excel');
echo $documento;