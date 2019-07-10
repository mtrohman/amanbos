<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Data Pengajuan RKAS</title>
<style type="text/css">

@media print
{
  .break{ display:block; page-break-before:always; }
}
.pala_judul {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	letter-spacing: normal;
	text-align: center;
	word-spacing: normal;
	list-style-type: none;
	vertical-align: baseline;
}
.style9 {color: #000000;
	font-size: 9pt;
	font-weight: normal;
	font-family: Arial;
}

.style9b {color: #000000;
	font-size: 9pt;
	font-weight: bold;
	font-family: Arial;
}

.style6 {	color: #000000;
	font-size: 9pt;
	font-weight: bold;
	font-family: Arial;
}

</style>
</head>

<body>
 <?php 
 error_reporting(0);
include"../../../koneksi/koneksi.php";

if(isset($_GET["dari"]))$dari = $_GET['dari'];
else $dari = "";

if(isset($_GET["sampai"]))$sampai = $_GET['sampai'];
else $sampai = "";


//construct where clause
$where = "WHERE 1=1";
if($dari!='')$where.= " AND date(tgl_buktibayar) >= '$dari'";
if($sampai!='')$where.= " AND date(tgl_buktibayar) <= '$sampai'";
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0">
<!-- <img src="http://bos.aplikasikami.com/laporan/kopdisbud2.png"> -->
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="67%" height="56" valign="top">&nbsp;</td>
        <td width="33%"><table width="100%" border="0">
            <tr>
              <td class="pala_judul"><div align="center">Laporan Data Pengajuan RKAS </div></td>
            </tr>
            <tr>
              <td height="28" class="pala_judul"><div align="center">Kabupaten Semarang</div></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr class="style9">
        <td>&nbsp;Dari Tanggal:
          <?=$_GET["dari"]?>
&nbsp;&nbsp;&nbsp;&nbsp;Sampai Tanggal:
<?=$_GET["sampai"]?></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="100%" border="1" cellpadding="0" cellspacing="0">
  <tr class="style6">
    <td width="2%"><div align="center">No</div></td>
    <td width="5%"><div align="center">NPSN</div></td>
    <td width="20"><div align="center">Nama Sekolah</div></td>
    <td width="5%"><div align="center">TA</div></td>
    <td width="7%"><div align="center">Pagu-awal</div></td>
    <td width="7%"><div align="center">Pagu-ubah</div></td>
    <td width="7%"><div align="center">TW1-awal</div></td>
    <td width="7%"><div align="center">TW1-ubah</div></td>
    <td width="7%"><div align="center">TW2-awal</div></td>
    <td width="7%"><div align="center">TW2-ubah</div></td>
    <td width="7%"><div align="center">TW3-awal</div></td>
    <td width="7%"><div align="center">TW3-ubah</div></td>
    <td width="7%"><div align="center">TW4-awal</div></td>
    <td width="7%"><div align="center">TW4-ubah</div></td>
  </tr>
  
   <?php $sql2 = mysql_query("SELECT a.id_buktibayar,a.id_faktur,c.id_pkb,nama,a.no_polisi,biaya,diskon,biaya-diskon as grand FROM buktibayar_dtl a
      INNER JOIN buktibayar_hdr b ON b.id_buktibayar=a.id_buktibayar
      INNER JOIN faktur c ON c.id_faktur=a.id_faktur
      INNER JOIN pkb d ON d.id_pkb=c.id_pkb
      INNER JOIN kendaraan e ON e.no_polisi=a.no_polisi
      INNER JOIN pelanggan f ON f.id_plg=e.id_plg
".$where." and lunas=1" ) or die(mysql_error());
		$i = 1;
		while ($rs2 = mysql_fetch_array($sql2)){	
		?>
  <tr>
    <td class="style9" align="center"><?=$i;?></td>
    <td class="style9"><?=$rs2['id_pkb'];?></td>
    <td class="style9"><?=$rs2['id_faktur'];?></td>
    <td class="style9"><?=$rs2['id_buktibayar'];?></td>
    <td class="style9"><?=$rs2['no_polisi'];?></td>
    <td class="style9"><?=$rs2['nama'];?></td>
     <td class="style9" align="right"><?=number_format($rs2['biaya']);?></td>
    <td class="style9" align="right"><?=number_format($rs2['diskon']);?></td>
     <td class="style9" align="right"><?=number_format($rs2['grand']);?></td>
  </tr>
  
   <?php 
   	$jml_biaya += $rs2['biaya'];
	$jml_diskon += $rs2['diskon'];
	$jml_grand += $rs2['grand'];
	  $i++;
	  }
	  
	  ?>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr class="style9">
        <td width="70%"><div align="center"><strong>JUMLAH</strong></div></td>
        <td width="9%" align="right"><strong>
          <?=number_format($jml_biaya);?>
        </strong></td>
        <td width="9%" align="right"><strong>
          <?=number_format($jml_diskon);?>
        </strong></td>
        <td width="12%" align="right"><strong>
          <?=number_format($jml_grand);?>
        </strong></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>

<script type="text/javascript">
window.print();
</script>
</html>
