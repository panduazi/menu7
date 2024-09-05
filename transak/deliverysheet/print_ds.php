<?php
 session_start();
 $location = $_SESSION['clocation'];
 $cuser = $_SESSION['cuser'];
 $group = $_SESSION['cgroup'];
 $office = $_SESSION['coffice'];
 $kurir = $_SESSION['MM_nmkurir'];
 
 $no=$_GET['nods'];
 include('../../config/koneksi.php');
 $sql=mysql_query("SELECT * FROM tbldeliverymaster WHERE DlvNo='$no' ");
 $hasil=mysql_fetch_array($sql);
 $ketemu=mysql_num_rows($sql);
 if($ketemu==1){
 	$dest=$hasil['DlvKurir'];
 	$tgl=$hasil['DlvDate'];
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Form Cetak Manifest</title>
  <style>
    body {
	 background-color: #FFFFFF;
	 font-family: Tahoma, Geneva, sans-serif;
	 font-size: 12px;
    }
  </style>
</head>
<body onload="window.print()" onfocus="window.close()">
  <div id="judul">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" rowspan="4"><img src="../../images/logo_besar.png" width="165" height="40" /></td>
    <td width="38%">&nbsp;</td>
    <td style="font-size:18px" align="right"  width="35%">Delivery Sheet Kurir</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="font-family:'Free 3 of 9'; font-size:24px" align="right"><? echo $no; ?></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">No. <? echo $no; ?></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td width="7%">Tanggal</td>
    <td width="20%">: <? echo $tgl; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Nama Kurir</td>
    <td>: <? echo $dest; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>: </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  </div>
  <div id="isi">
	<table width="100%" border="1" cellpadding="2" cellspacing="0">
	  <tr>
    	<td width="3%"><strong>NO.</strong></td>
    	<td width="10%"><strong>AWB NO.</strong></td>
    	<td width="10%"><strong>TANGGAL</strong></td>
    	<td width="20%"><strong>PENGIRIM</strong></td>
    	<td width="20%"><strong>NAMA DITUJU</strong></td>
    	<td width="30%"><strong>KOTA</strong></td>
    	<td width="10%"><strong>BERAT</strong></td>
    	<td width="10%"><strong>KOLI</strong></td>
    	<td width="30%"><strong>NAMA PENERIMA</strong></td>
    	<td width="30%"><strong>JAM</strong></td>
        
	  </tr>
      <?php 
		include('../../config/koneksi.php');
 $query=mysql_query("select * from (tbldeliverydetail left join tblconnote on DRKonosNo=ConnoteNo) left join tblcity on ConnoteDest=CityId where DRNo='$no'");
	  	$i=1;
	  	while ($hasil=mysql_fetch_array($query)){
		  $brt=number_format($hasil[ConnoteWeight]);
		  $qty=number_format($hasil[ConnoteQty]);
      	  echo "<tr bgcolor='$bg' >";
      	  echo "<td align='left'>$i</td>";
      	  echo "<td align='left'>$hasil[DRKonosNo]</td>";
     	  echo "<td align='left'>$hasil[ConnoteDate]</td>";
      	  echo "<td align='left'>$hasil[ConnoteCustName]</td>";
      	  echo "<td align='left'>$hasil[ConnoteRecvName]</td>";
      	  echo "<td align='left'>$hasil[CityName]</td>";
      	  echo "<td align='right'>$brt</td>";
      	  echo "<td align='right'>$qty</td>";
      	  echo "<td></td>";
      	  echo "<td></td>";
    	  echo "</tr>";
	  	  $i++;
	  	}
	?>
	</table>
  </div>
</body>
</html>