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
$npsn= $_POST['npsn'];
$ta= $_POST['ta'];
$teks_saldo_tahun= "TAHUN ".($ta-1);
$triwulan= $_POST['tw'];
$triwulan1= [1 ,2 ,3 ];
$triwulan2= [4 ,5 ,6 ];
$triwulan3= [7 ,8 ,9 ];
$triwulan4= [10,11,12];
$akhirtanggal = ($triwulan==1||$triwulan==4) ? 31 : ($triwulan==2||$triwulan==3) ? 30 : 0 ;
$bulanawal = ${"triwulan".$triwulan};

$nomor_sptj= $_POST['nomor_sptj'];
$sekolah= Sekolah::npsn($npsn)->first();
$nama_sekolah= $sekolah->nama_sekolah;
$nama_kepsek= $sekolah->nama_kepsek;
$nip_kepsek= $sekolah->nip_kepsek;
$jenjang= $sekolah->jenjang;

/*if ($triwulan==3 || $triwulan==4) {
	$semester="I";
}
elseif($triwulan==1 || $triwulan==2){
	$semester="II";
}*/
function twhuruf($triwulan)
{
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
	return $twhuruf;
}
$twloop="";
for ($i=1; $i <= $triwulan ; $i++) {
	if ($i==1) {
		# code...
		$twloop.="Triwulan ".twhuruf($i);
	}
	elseif ($i<$triwulan) {
		# code...
		$twloop.=", Triwulan ".twhuruf($i);
	}
	elseif ($i==$triwulan){
		$twloop.=" dan Triwulan ".twhuruf($i);
	}
}
$paragraf_terakhir= "penggunaan Dana BOS pada ".$twloop." Tahun Anggaran ".$ta." dengan rincian sebagai berikut:";

$saldo_thlalu=Saldo::ta($ta-1)->npsn($npsn)->get()->sum('sisa');

$penerimaan_tw1=0;
$penerimaan_tw2=0;
$penerimaan_tw3=0;
$penerimaan_tw4=0;
$penerimaanpertw="penerimaan_tw";

for ($i=1; $i <= $triwulan ; $i++) { 
	${$penerimaanpertw.$i}=Pencairan::npsn($npsn)->ta($ta)->triwulan($i)->get()->sum('saldo');
}

// $penerimaan_tw1= Pencairan::npsn($npsn)->ta($ta)->triwulan(1)->get()->sum('saldo');
// $penerimaan_tw2= Pencairan::npsn($npsn)->ta($ta)->triwulan(2)->get()->sum('saldo');
// $penerimaan_tw3= Pencairan::npsn($npsn)->ta($ta)->triwulan(3)->get()->sum('saldo');
// $penerimaan_tw4= Pencairan::npsn($npsn)->ta($ta)->triwulan(4)->get()->sum('saldo');

$belanjar1_sd_tw_sekarang= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->sampaiTriwulan($triwulan)->with('rka.rekening')->parentRekening(1)->get()->sum('nilai');
$belanjar2_sd_tw_sekarang= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->sampaiTriwulan($triwulan)->with('rka.rekening')->parentRekening(2)->get()->sum('nilai');
$belanjar3_sd_tw_sekarang= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->sampaiTriwulan($triwulan)->with('rka.rekening')->parentRekening(3)->get()->sum('nilai');
$belanjar4_sd_tw_sekarang= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->sampaiTriwulan($triwulan)->with('rka.rekening')->parentRekening(4)->get()->sum('nilai');
$belanjar5_sd_tw_sekarang= Belanja::npsn($npsn)->ta($ta)->thBerjalan()->sampaiTriwulan($triwulan)->with('rka.rekening')->parentRekening(5)->get()->sum('nilai');
$belanjar345_sd_tw_sekarang= $belanjar3_sd_tw_sekarang+$belanjar4_sd_tw_sekarang+$belanjar5_sd_tw_sekarang;
// echo json_encode($belanjar345_sd_tw_sekarang);

$tanggal= $akhirtanggal." ".bln_indo($bulanawal[2])." ".$ta;
$tanggal_tempat= "Kab. Semarang, ".$tanggal;

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('format/sptj.xlsx');

$worksheet = $spreadsheet->getActiveSheet();

$worksheet->getCell('nomor_sptj')->setValue($nomor_sptj);
$worksheet->getCell('nama_sekolah')->setValue($nama_sekolah);
$worksheet->getCell('kode_organisasi')->setValue($npsn);
$worksheet->getCell('jenjang')->setValue($jenjang);
$worksheet->getCell('paragraf_terakhir')->setValue($paragraf_terakhir);
$worksheet->getCell('teks_saldo_tahun')->setValue($teks_saldo_tahun);
$worksheet->getCell('saldo_thlalu')->setValue($saldo_thlalu);

$worksheet->getCell('penerimaan_tw1')->setValue($penerimaan_tw1);
$worksheet->getCell('penerimaan_tw2')->setValue($penerimaan_tw2);
$worksheet->getCell('penerimaan_tw3')->setValue($penerimaan_tw3);
$worksheet->getCell('penerimaan_tw4')->setValue($penerimaan_tw4);

$worksheet->getCell('belanjar1_sd_tw_sekarang')->setValue($belanjar1_sd_tw_sekarang);
$worksheet->getCell('belanjar2_sd_tw_sekarang')->setValue($belanjar2_sd_tw_sekarang);
$worksheet->getCell('belanjar345_sd_tw_sekarang')->setValue($belanjar345_sd_tw_sekarang);

$kas_tunai=0;
$worksheet->getCell('kas_tunai')->setValue($kas_tunai);

$worksheet->getCell('tanggal_tempat')->setValue($tanggal_tempat);
$worksheet->getCell('nama_kepsek')->setValue($nama_kepsek);
$worksheet->getCell('nip_kepsek')->setValue("NIP.".$nip_kepsek);

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
$file= 'sptj_'.$ta.'_tw'.$triwulan.'_'.$npsn.'.xlsx';
$documento = file_get_contents($temp_file);
unlink($temp_file);  // delete file tmp
header("Content-Disposition: attachment; filename= ".$file."");
header('Content-Type: application/excel');
echo $documento;

