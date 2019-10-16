<?php
require 'vendor/autoload.php';
include_once 'config/db.php';
require_once 'config/dbmanager.php';
// include_once 'ceklogin.php';
use Illuminate\Database\Capsule\Manager as DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Sekolah;
use App\Models\Rka;
use App\Models\Belanja;
use App\Models\KodeProgram;
use App\Models\KodePembiayaan;
use App\Models\Pencairan;

// Kode Rekening
$kr_all = array();
$res_kr = DB::select('call koderekening_lengkap()');
foreach ($res_kr as $key => $value) {
    $kr_all[$value->id] = $value;
}

// Lap Realisasi
$npsn= $_POST['npsn'];
$ta= $_POST['ta'];
// $triwulan= $_GET['tw'];
// $bulan= $_GET['bln'];
$sekolah= Sekolah::npsn($npsn)->first();
$nama_sekolah= $sekolah->nama_sekolah;
$nama_kepsek= $sekolah->nama_kepsek;
$nip_kepsek= $sekolah->nip_kepsek;
$nama_bendahara= $sekolah->nama_bendahara;
$nip_bendahara= $sekolah->nip_bendahara;
$nama_kecamatan= $sekolah->kecamatannya->nama_kecamatan;
$desa_kecamatan="- /".$nama_kecamatan;

$bku_content= array();
$col_start= "B";
$row_start= 12;
$belanjas= Belanja::with('rka.kp','rka.program')->ta($ta)->npsn($npsn)->thBerjalan()->orderBy('tanggal_belanja')->get();
// echo json_encode($belanjas);
$i=0;
$bku_content[$i]['tanggal']="";
$bku_content[$i]['kode_bku']="";
$bku_content[$i]['no_bukti']="";
// $bku_content[$i]['kosong']="";
$bku_content[$i]['uraian']="Saldo Tahun Lalu";
$bku_content[$i]['penerimaan']=0;
$bku_content[$i]['pengeluaran']="";
$bku_content[$i]['saldo']="=F".($row_start+$i)." - G".($row_start+$i);

$pencairans= Pencairan::ta($ta)->npsn($npsn)->whereBetween('triwulan',[1,2])->get();
$arrpencairan = array();
foreach ($pencairans as $keypencairan => $pencairan) {
    $arrpencairan[$keypencairan]= new stdClass();
    $arrpencairan[$keypencairan]->tanggal_belanja= $pencairan->tanggal_pencairan;
    $arrpencairan[$keypencairan]->nomor= "";
    $arrpencairan[$keypencairan]->penerimaan= true;
    $arrpencairan[$keypencairan]->nama= "Penerimaan dana ".$pencairan->sumber_dana." Triwulan ".$pencairan->triwulan;
    $arrpencairan[$keypencairan]->nilai= $pencairan->saldo;
}

$objbku= $belanjas->concat($arrpencairan);
$objbku= $objbku->sortBy('tanggal_belanja');
$objbku= $objbku->values()->all();
// ->all()
// ->sortBy('tanggal_belanja')
// echo json_encode($objbku);

// array_push($arrbku, $belanjas);
// array_push($belanjas, $objpencairan);

foreach ($objbku as $keybelanja => $belanja) {
    $i++;
	$bku_content[$i]['tanggal']=tgl_indo($belanja->tanggal_belanja);
    if (!empty($belanja->rka)) {
        # code...
        $bku_content[$i]['kode_bku']=$belanja->rka->program->id."/".$kr_all[$belanja->rka->rekening_id]->path."/".$belanja->rka->kp->kode_pembiayaan;
    }
    else{
        $bku_content[$i]['kode_bku']="";
    }
    $bku_content[$i]['no_bukti']=$belanja->nomor;
    // $bku_content[$i]['kosong']="";
    $bku_content[$i]['uraian']=$belanja->nama;

    if (!empty($belanja->penerimaan)) {
        # code...
        $bku_content[$i]['penerimaan']=$belanja->nilai;
        $bku_content[$i]['pengeluaran']="";
    }
    else{
        $bku_content[$i]['penerimaan']="";
        $bku_content[$i]['pengeluaran']=$belanja->nilai;
    }

    $bku_content[$i]['saldo']="=H".($row_start+($i-1))." + F".($row_start+$i)." - G".($row_start+$i);


    if (!empty($belanja->ppn)) {
        $i++;
        $bku_content[$i]['tanggal']=tgl_indo($belanja->tanggal_belanja);
        $bku_content[$i]['kode_bku']=$belanja->rka->program->id."/".$kr_all[$belanja->rka->rekening_id]->path."/".$belanja->rka->kp->kode_pembiayaan;
        $bku_content[$i]['no_bukti']=$belanja->nomor;
        // $bku_content[$i]['kosong']="";
        $bku_content[$i]['uraian']="Pajak PPN";
        $bku_content[$i]['penerimaan']=$belanja->ppn;
        $bku_content[$i]['pengeluaran']="";
        $bku_content[$i]['saldo']="=H".($row_start+($i-1))." + F".($row_start+$i)." - G".($row_start+$i);

        $i++;
        $bku_content[$i]['tanggal']=tgl_indo($belanja->tanggal_belanja);
        $bku_content[$i]['kode_bku']=$belanja->rka->program->id."/".$kr_all[$belanja->rka->rekening_id]->path."/".$belanja->rka->kp->kode_pembiayaan;
        $bku_content[$i]['no_bukti']=$belanja->nomor;
        // $bku_content[$i]['kosong']="";
        $bku_content[$i]['uraian']="Pajak PPN";
        $bku_content[$i]['penerimaan']="";
        $bku_content[$i]['pengeluaran']=$belanja->ppn;
        $bku_content[$i]['saldo']="=H".($row_start+($i-1))." + F".($row_start+$i)." - G".($row_start+$i);
    }

    if (!empty($belanja->pph21)) {
        $i++;
        $bku_content[$i]['tanggal']=tgl_indo($belanja->tanggal_belanja);
        $bku_content[$i]['kode_bku']=$belanja->rka->program->id."/".$kr_all[$belanja->rka->rekening_id]->path."/".$belanja->rka->kp->kode_pembiayaan;
        $bku_content[$i]['no_bukti']=$belanja->nomor;
        // $bku_content[$i]['kosong']="";
        $bku_content[$i]['uraian']="Pajak PPH 21";
        $bku_content[$i]['penerimaan']=$belanja->pph21;
        $bku_content[$i]['pengeluaran']="";
        $bku_content[$i]['saldo']="=H".($row_start+($i-1))." + F".($row_start+$i)." - G".($row_start+$i);

        $i++;
        $bku_content[$i]['tanggal']=tgl_indo($belanja->tanggal_belanja);
        $bku_content[$i]['kode_bku']=$belanja->rka->program->id."/".$kr_all[$belanja->rka->rekening_id]->path."/".$belanja->rka->kp->kode_pembiayaan;
        $bku_content[$i]['no_bukti']=$belanja->nomor;
        // $bku_content[$i]['kosong']="";
        $bku_content[$i]['uraian']="Pajak PPH 21";
        $bku_content[$i]['penerimaan']="";
        $bku_content[$i]['pengeluaran']=$belanja->pph21;
        $bku_content[$i]['saldo']="=H".($row_start+($i-1))." + F".($row_start+$i)." - G".($row_start+$i);
    }

    if (!empty($belanja->pph23)) {
        $i++;
        $bku_content[$i]['tanggal']=tgl_indo($belanja->tanggal_belanja);
        $bku_content[$i]['kode_bku']=$belanja->rka->program->id."/".$kr_all[$belanja->rka->rekening_id]->path."/".$belanja->rka->kp->kode_pembiayaan;
        $bku_content[$i]['no_bukti']=$belanja->nomor;
        // $bku_content[$i]['kosong']="";
        $bku_content[$i]['uraian']="Pajak PPH 23";
        $bku_content[$i]['penerimaan']=$belanja->pph23;
        $bku_content[$i]['pengeluaran']="";
        $bku_content[$i]['saldo']="=H".($row_start+($i-1))." + F".($row_start+$i)." - G".($row_start+$i);

        $i++;
        $bku_content[$i]['tanggal']=tgl_indo($belanja->tanggal_belanja);
        $bku_content[$i]['kode_bku']=$belanja->rka->program->id."/".$kr_all[$belanja->rka->rekening_id]->path."/".$belanja->rka->kp->kode_pembiayaan;
        $bku_content[$i]['no_bukti']=$belanja->nomor;
        // $bku_content[$i]['kosong']="";
        $bku_content[$i]['uraian']="Pajak PPH 23";
        $bku_content[$i]['penerimaan']="";
        $bku_content[$i]['pengeluaran']=$belanja->pph23;
        $bku_content[$i]['saldo']="=H".($row_start+($i-1))." + F".($row_start+$i)." - G".($row_start+$i);
    }
}
// echo json_encode($belanjas);


$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('format/bku.xlsx');

$worksheet = $spreadsheet->getActiveSheet();

$worksheet->getCell('nama_sekolah')->setValue($nama_sekolah);
$worksheet->getCell('desa_kecamatan')->setValue($desa_kecamatan);
$worksheet->getCell('nama_kepsek')->setValue($nama_kepsek);
$worksheet->getCell('nip_kepsek')->setValue("NIP.".$nip_kepsek);
$worksheet->getCell('nama_bendahara')->setValue($nama_bendahara);
$worksheet->getCell('nip_bendahara')->setValue("NIP.".$nip_bendahara);

$worksheet->fromArray(
    $bku_content,
    NULL,
    $col_start.$row_start
);


/*$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('output.xlsx');*/

/*$spreadsheet->getActiveSheet()
    ->getProtection()->setPassword('K8');
$spreadsheet->getActiveSheet()
    ->getProtection()->setSheet(true);
$spreadsheet->getActiveSheet()
    ->getProtection()->setFormatCells(false);*/

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$temp_file = tempnam(sys_get_temp_dir(), 'Excel');
$writer->save($temp_file);
$file= 'bku_'.$ta.'_thberjalan_'.$npsn.'.xlsx';
$documento = file_get_contents($temp_file);
unlink($temp_file);  // delete file tmp
header("Content-Disposition: attachment; filename= ".$file."");
header('Content-Type: application/excel');
echo $documento;