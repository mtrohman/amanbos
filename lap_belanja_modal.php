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
use App\Models\BelanjaModal;
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
$bulanarr = ${"triwulan".$triwulan};
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
$sub_judul="TRIWULAN ".$twhuruf." TAHUN ANGGARAN ".$ta;
// echo json_encode($periode);

$sekolah= Sekolah::npsn($npsn)->first();
$nama_sekolah= $sekolah->nama_sekolah;
$nama_kepsek= $sekolah->nama_kepsek;
$nip_kepsek= $sekolah->nip_kepsek;
// $nama_bendahara= $sekolah->nama_bendahara;
// $nip_bendahara= $sekolah->nip_bendahara;
$nama_kecamatan= $sekolah->kecamatannya->nama_kecamatan;

$bulan1= bln_indo($bulanarr[0]);
$bulan2= bln_indo($bulanarr[1]);
$bulan3= bln_indo($bulanarr[2]);

$barang_modal= array();
$belanja_modal= BelanjaModal::npsn($npsn)->with('kd_barang')->get();
foreach ($belanja_modal as $key => $modal) {
    $barang_modal[$key]['kode_barang']= $modal->kd_barang->kode_barang;
    $barang_modal[$key]['nama_barang']= $modal->nama_barang;
    $barang_modal[$key]['merek']= $modal->merek;
    $barang_modal[$key]['warna']= $modal->warna;
    $barang_modal[$key]['tipe']= $modal->tipe;
    $barang_modal[$key]['bahan']= $modal->bahan;
    $barang_modal[$key]['bukti_tanggal']= date('d', strtotime($modal->bukti_tanggal));
    $barang_modal[$key]['bukti_bulan']= bln_indo(date('n', strtotime($modal->bukti_tanggal)));
    $barang_modal[$key]['bukti_nomor']= $modal->bukti_nomor;
    $barang_modal[$key]['qty']= $modal->qty;
    $barang_modal[$key]['satuan']= $modal->satuan;
    $barang_modal[$key]['jenis']= $modal->belanja->rka->rekening->parent_id;
    $barang_modal[$key]['harga_satuan']= $modal->harga_satuan;
       
}
// echo json_encode($barang_modal);


$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('format/belanja_modal.xlsx');

$worksheet = $spreadsheet->getActiveSheet();

$worksheet->getCell('sub_judul')->setValue($sub_judul);
$worksheet->getCell('nama_sekolah')->setValue($nama_sekolah);
$worksheet->getCell('nama_kecamatan')->setValue($nama_kecamatan);
$worksheet->getCell('nama_kepsek')->setValue($nama_kepsek);
$worksheet->getCell('nip_kepsek')->setValue("NIP.".$nip_kepsek);
$worksheet->getCell('bulan1')->setValue($bulan1);
$worksheet->getCell('bulan2')->setValue($bulan2);
$worksheet->getCell('bulan3')->setValue($bulan3);

$worksheet->fromArray(
    $barang_modal,
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
$file= 'b_modal_'.$ta.'_tw'.$triwulan.'_'.$npsn.'.xlsx';
$documento = file_get_contents($temp_file);
unlink($temp_file);  // delete file tmp
header("Content-Disposition: attachment; filename= ".$file."");
header('Content-Type: application/excel');
echo $documento;