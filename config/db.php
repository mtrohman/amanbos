<?php  
include_once 'link.php';
$namaweb="Disdikbudpora Kabupaten Semarang";
// $warnaweb="blue-dark";
$warnaweb = "blue";

$link = mysqli_connect($server, $user, $pass, $db, 3306);

if (!$link) {
    echo "Error: Unable to connect to MySQLi." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

session_start();
function rupiah($angka){
	
	$hasil_rupiah = /*number_format($angka,2,',','.');*/
	"<div class='pull-left'>Rp</div>" . number_format($angka,2,',','.')."";
	return $hasil_rupiah;
 
}

function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tahun
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tanggal

	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function bln_indo($angka){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);

	return $bulan[ (int)$angka ];
}

function triwulan($stringtanggal){
	# code...
	$bln = date("m",strtotime($stringtanggal));
	$triwulan = $bln >= 1 && $bln <= 3 ? 1 : ($bln >= 4 && $bln <= 6 ? 2 : ($bln >= 7 && $bln <= 9 ? 3 : 4));
	return $triwulan;
}
function bln_pendek($angka){
	$bulan = array (
		1 =>   'Jan',
		'Feb',
		'Mar',
		'Apr',
		'Mei',
		'Jun',
		'Jul',
		'Ags',
		'Sep',
		'Okt',
		'Nov',
		'Des'
	);

	return $bulan[ (int)$angka ];
}

function indonesian_date ($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
    if (trim ($timestamp) == '')
    {
            $timestamp = time ();
    }
    elseif (!ctype_digit ($timestamp))
    {
        $timestamp = strtotime ($timestamp);
    }
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
    $date_format = preg_replace ("/S/", "", $date_format);
    $pattern = array (
        '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
        '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
        '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
        '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
        '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
        '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
        '/April/','/June/','/July/','/August/','/September/','/October/',
        '/November/','/December/',
    );
    $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
        'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
        'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
        'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
        'Oktober','November','Desember',
    );
    $date = date ($date_format, $timestamp);
    $date = preg_replace ($pattern, $replace, $date);
    $date = "{$date} {$suffix}";
    // $date = "{$date}";
    return $date;
} 

function ParseFloat($floatString){ 
    $LocaleInfo = localeconv(); 
    $floatString = str_replace($LocaleInfo["mon_thousands_sep"] , "", $floatString); 
    $floatString = str_replace($LocaleInfo["mon_decimal_point"] , ".", $floatString); 
    return floatval($floatString); 
}

function nilai_koma($nilaiFloat){
	return str_replace(".", ",", $nilaiFloat);
}

function random_text($panjang){
	# code...
	$karakter	= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$string 	= '';
	for ($i=0; $i < $panjang; $i++) { 
		# code...
		$pos = rand(0, strlen($karakter)-1);
		$string .= $karakter[$pos];
	}
	return $string;
}

?>