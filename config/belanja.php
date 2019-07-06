<?php
function limitrka($tahun,$triwulan,$npsn)
{
	include 'link.php';
	$link1 = mysqli_connect($server, $user, $pass, $db, 3306);

	if (!$link1) {
	    echo "Error: Unable to connect to MySQLi." . PHP_EOL;
	    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
	    exit;
	}
	$sqllimit= "SELECT 
	id, 
	ta, 
	npsn, 
	t".$triwulan."_pegawai as pegawai, 
	t".$triwulan."_barangjasa as barangjasa, 
	t".$triwulan."_alatmesin as alatmesin, 
	t".$triwulan."_asetlainnya as asetlainnya, 
	t".$triwulan."_gedungbangunan as gedungbangunan
	FROM pengajuanrka
	WHERE ta='$tahun' AND
	npsn= '$npsn'";

	$res= mysqli_query($link1,$sqllimit);
	$arr= mysqli_fetch_assoc($res);

	mysqli_close($link1);
	return $arr;
}

function saldotriwulan($tahun,$triwulan,$npsn)
{
	include 'link.php';
	$link1 = mysqli_connect($server, $user, $pass, $db, 3306);

	if (!$link1) {
	    echo "Error: Unable to connect to MySQLi." . PHP_EOL;
	    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
	    exit;
	}
	$sqlsaldo= "SELECT 
	id, 
	ta, 
	npsn, 
	pegawai, 
	barangjasa, 
	alatmesin, 
	asetlainnya, 
	gedungbangunan,
	saldo
	FROM saldotriwulan
	WHERE ta='$tahun' AND
	npsn= '$npsn'";

	$res= mysqli_query($link1,$sqlsaldo);
	$arr= mysqli_fetch_assoc($res);

	mysqli_close($link1);
	return $arr;
}

function getparent($id){
	include 'link.php';
	$link1 = mysqli_connect($server, $user, $pass, $db, 3306);

	if (!$link1) {
	    echo "Error: Unable to connect to MySQLi." . PHP_EOL;
	    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
	    exit;
	}
	$sqlparent= "SELECT parent_id FROM koderekening WHERE id='$id'";
	$res= mysqli_query($link1,$sqlparent);
	$arr= mysqli_fetch_assoc($res);

	mysqli_close($link1);
	return $arr['parent_id'];
}

function kategoribelanja($parent)
{
	switch ($parent) {
		case 1:
			# code...
			$res="pegawai";
			break;
		case 2:
			# code...
			$res="barangjasa";
			break;
		case 3:
			# code...
			$res="alatmesin";
			break;
		case 4:
			# code...
			$res="asetlainnya";
			break;
		case 5:
			# code...
			$res="gedungbangunan";
			break;
	}

	return $res;
}
?>