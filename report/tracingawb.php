<?
 if (isset($_POST['btcari'])) {
 	$ckey=$_POST['edno'];
 	include('config/koneksi.php'); 
 	$sql0=mysql_query("select * from tblconnote left join tblcity on ConnoteDest=CityId where ConnoteNo='$ckey'");
 	$hasil0=mysql_fetch_array($sql0);
 	if (mysql_num_rows($sql0)>0) {
 		$noawb=$hasil0['ConnoteNo'];
 		$nocust=$hasil0['ConnoteCustNo'];
 		$nmcust=$hasil0['ConnoteCustName'];
 		$nmrecv=$hasil0['ConnoteRecvName'];
 		$alrecv=$hasil0['ConnoteRecvAddr'];
 		$kota=$hasil0['CityName'];
		$tgl=$hasil0['ConnoteDate'];
		$brt=$hasil0['ConnoteWeight'];
		$qty=$hasil0['ConnoteQty'];
		
 	} 
 	else {
 		$noawb='NA#';
 		$nocust='';
 		$nmcust='';
 		$nmrecv='';
 		$alrecv='';
 		$kota='';
 	}
 }
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Track and Trace Shipment</title>
 		<link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
 		<link rel="stylesheet" type="text/css" href="themes/icon.css">
 		<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
<script type="text/javascript" src="jq/jquery.min.js"></script>
<script type="text/javascript" src="jq/jquery.easyui.min.js"></script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr>
  <form action="?hal=trace" method="post">
    <td style="font-size:16px" colspan="2"><h1>Trace &amp; Track Shipment</h1></td>
    <td>Cari No AWB : <input type="text" name="edno" id="edno" />
      <input type="submit" name="btcari" id="btcari" value="Submit" /></td>
  </form>
  </tr>
  <tr>
    <td colspan="3"><hr /></td>
  </tr>
  <tr>
    <td width="11%">No Connote</td>
    <td width="52%">: <strong><? echo $ckey ?></strong></td>
    <td width="37%">&nbsp;</td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td>: <strong><? echo $tgl ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Pengirim</td>
    <td>: <strong><? echo $nmcust ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama di tuju</td>
    <td>: <strong><? echo $nmrecv ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Alamat tujuan</td>
    <td valign="top" rowspan="2">: <strong><? echo $alrecv ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td>Via</td>
    <td>: <strong><? echo $kota ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Berat</td>
    <td>: <strong><? echo $brt ?></strong> Kg. - Koli : <strong><? echo $qty ?></strong></td>
    <td>&nbsp;</td>
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
 	include('config/koneksi.php'); 
 	$sql1=mysql_query("SELECT * FROM (tbltrackingstatus left join tbllocation ON StatusOffice=LocId) left join tbltrackingcode ON StatusPOD=Id WHERE StatusKonosNo='$ckey'");
	$i=1;
	while ($row=mysql_fetch_array($sql1)) {
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