<?
 $ckey=$_GET['id'];
 include('../config/koneksi.php'); 
 $sql0=mysql_query("select * from tblConnote left join tblCity on ConnoteDest=CityId where ConnoteNo='$ckey'");
 $hasil0=mysql_fetch_array($sql0);
 $noawb=$hasil0['ConnoteNo'];
 $nocust=$hasil0['ConnoteCustNo'];
 $nmcust=$hasil0['ConnoteCustName'];
 $nmrecv=$hasil0['ConnoteRecvName'];
 $alrecv=$hasil0['ConnoteRecvAddr'];
 $kota=$hasil0['CityName'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Track and Trace Shipment</title>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3">Trace &amp; Track Shipment</td>
  </tr>
  <tr>
    <td width="14%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
    <td width="85%">&nbsp;</td>
  </tr>
  <tr>
    <td>No Connote</td>
    <td>:</td>
    <td><? echo $ckey ?></td>
  </tr>
  <tr>
    <td>Nama Pengirim</td>
    <td>:</td>
    <td><? echo $nmcust ?></td>
  </tr>
  <tr>
    <td>Nama di tuju</td>
    <td>:</td>
    <td><? echo $nmrecv ?></td>
  </tr>
  <tr>
    <td>Alamat tujuan</td>
    <td valign="top" rowspan="2">:</td>
    <td><? echo $alrecv ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td>Via</td>
    <td>:</td>
    <td><? echo $kota ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="100%" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="jud_tabel">Lokasi</td>
    <td><div class="jud_tabel">Waktu</td>
    <td><div class="jud_tabel">Status CekPoint</td>
    <td><div class="jud_tabel">Keterangan</td>
  </tr>
	<?php
	include('../config/koneksi.php');
	$sql = mysql_query("SELECT * FROM tblTrackingStatus left join tblStatusPOD ON StatusPOD=StatusPODId WHERE StatusKonosNo='$noawb'");
	$i=1;
	while ($row=mysql_fetch_array($sql)) {
      	echo "<td align='left'>$row[LocName]</td>";
      	echo "<td align='left'>$row[RecId]</td>";
      	echo "<td align='left'>$row[CPName]</td>";
      	echo "<td align='left'>$row[StatusDesc]</td>";
      	echo "</tr>";
	  	$i++;
	}
	?>
</table>

</body>
</html>