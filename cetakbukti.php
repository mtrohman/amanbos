<?php

include_once 'config/db.php';
// include_once '../../ceklogin.php';
require_once 'config/dbmanager.php';
use Illuminate\Database\Capsule\Manager as DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Sekolah;
use App\Models\Belanja;

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('bukti_pengeluaran.xlsx');

$worksheet = $spreadsheet->getActiveSheet();
$bid= $_GET['id'];
$belanja= Belanja::find($bid);

$kr_all = array();
$res_kr = DB::select('call koderekening_lengkap()');
foreach ($res_kr as $key => $value) {
    $kr_all[$value->id] = $value;
}

if (!empty($belanja)) {
	$npsn= $belanja->npsn;
	$sekolah= Sekolah::npsn($npsn)->first();
	$namaprogram= $belanja->rka->program->nama_program;
	$namakp= $belanja->rka->kp->nama_pembiayaan;
	$namasekolah= $sekolah->nama_sekolah;
	$namakecamatan= $sekolah->kecamatannya->nama_kecamatan;
	// echo json_encode($belanja);
	//-----------------------------------------------
	$ta= $belanja->rka->ta;
	$tanggal= tgl_indo($belanja->tanggal_belanja);
	$nomor= $belanja->nomor;	
	$judul= $namasekolah." - ".$namakecamatan;
	$penerima= $belanja->penerima;
	$uang_digit= $belanja->nilai;
	$uang_terbilang= terbilang($uang_digit);
	$pembayaran= $belanja->nama;
	$keperluan= $namaprogram." / ".$namakp;
	$kode_rekening= $kr_all[$belanja->rka->rekening_id]->path." / ".$kr_all[$belanja->rka->rekening_id]->nama_rekening;
	$jumlah_kotor= $belanja->nilai;
	$ppn= "PPN: ".cetakrupiah($belanja->ppn);
	$pph_21= "PPH21: ".cetakrupiah($belanja->pph21);
	$pph_23= "PPH23: ".cetakrupiah($belanja->pph23);
	$jumlah_bersih= $jumlah_kotor-$belanja->ppn-$belanja->pph21-$belanja->pph23;
	$ttd_penerima= $belanja->penerima;
	$nama_kepalasekolah= $sekolah->nama_kepsek;
	$nip_kepalasekolah= "NIP. ".$sekolah->nip_kepsek;
	$nama_bendahara= $sekolah->nama_bendahara;
	$nip_bendahara= "NIP. ".$sekolah->nip_bendahara;
}

$worksheet->getCell('nama_kepalasekolah')->setValue($nama_kepalasekolah);
$worksheet->getCell('nip_kepalasekolah')->setValue($nip_kepalasekolah);
$worksheet->getCell('nama_bendahara')->setValue($nama_bendahara);
$worksheet->getCell('nip_bendahara')->setValue($nip_bendahara);
$worksheet->getCell('ttd_penerima')->setValue($ttd_penerima);
$worksheet->getCell('jumlah_bersih')->setValue(cetakrupiah($jumlah_bersih));
$worksheet->getCell('jumlah_kotor')->setValue(cetakrupiah($jumlah_kotor));
$worksheet->getCell('ppn')->setValue($ppn);
$worksheet->getCell('pph_21')->setValue($pph_21);
$worksheet->getCell('pph_23')->setValue($pph_23);
$worksheet->getCell('keperluan')->setValue($keperluan);
$worksheet->getCell('kode_rekening')->setValue($kode_rekening);
$worksheet->getCell('pembayaran')->setValue($pembayaran);
$worksheet->getCell('uang_digit')->setValue($uang_digit);
$worksheet->getCell('uang_terbilang')->setValue($uang_terbilang);
$worksheet->getCell('penerima')->setValue($penerima);
$worksheet->getCell('judul')->setValue($judul);
$worksheet->getCell('ta')->setValue($ta);
$worksheet->getCell('nomor')->setValue($nomor);
$worksheet->getCell('tanggal')->setValue($tanggal);

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
// $writer->save('laporan/bukti_bid_'.$belanja->id.'.xlsx');
$file= 'laporan/bukti_bid_'.$belanja->id.'.xlsx';
$writer->save($file);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$file.'"');
$writer->save("php://output");