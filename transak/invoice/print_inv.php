<?php
 session_start();
 $location = $_SESSION['clocation'];
 $cuser = $_SESSION['cuser'];
 $group = $_SESSION['cgroup'];
 $office = $_SESSION['coffice'];
 $codeorig = $_SESSION['corigincode'];
 $nameorig = $_SESSION['coriginname'];

 $no=$_GET['noinv'];
 include('../../config/koneksi.php');
 $sql=mysql_query("SELECT * FROM tblinvoice WHERE InvoiceNo='$no'");
 $hasil=mysql_fetch_array($sql);
 $ketemu=mysql_num_rows($sql);
 if($ketemu==1){
 	$nmcust=$hasil['InvoiceName'];
 	$alcust=$hasil['InvoiceAddr1'];
	$period=$hasil['InvoicePeriode'];
	$tglinv=$hasil['InvoiceDate'];
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Form Cetak Invoice</title>
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
    <td width="26%">&nbsp;</td>
    <td style="font-size:18px" align="right"  width="47%">INVOICE</td>
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
    <td align="right">Tanggal : <? echo $tglinv; ?></td>
    </tr>
  <tr>
    <td width="7%">Kepada</td>
    <td valign="top" colspan="2" rowspan="2">: <? echo $nmcust; ?></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Periode</td>
    <td width="20%">: <? echo $period; ?></td>
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
	<table width="100%" border="0" cellpadding="2" cellspacing="0">
	  <tr>
       <td colspan="8"><hr /> </td>
	  </tr>
	  <tr>
    	<td width="3%"><strong>NO.</strong></td>
    	<td width="10%"><strong>AWB NO.</strong></td>
    	<td width="12%"><strong>TANGGAL</strong></td>
    	<td width="20%"><strong>NAMA DITUJU</strong></td>
    	<td width="20%"><strong>KOTA</strong></td>
    	<td align="right" width="5%"><strong>BERAT</strong></td>
    	<td align="right" width="5%"><strong>KOLI</strong></td>
    	<td align="right" width="10%"><strong>NILAI Rp.</strong></td>
	  </tr>
	  <tr>
       <td colspan="8"><hr /> </td>
	  </tr>
      <?php 
		include('../../config/koneksi.php');
 $query=mysql_query("select * from (tblinvoicedtl left join tblconnote on SD_ConnoteNo=ConnoteNo) left join tblcity on ConnoteDest=CityId where SD_InvoiceNo='$no'");
	  	$i=1;
		$totnilai=0;		
	  	while ($hasil=mysql_fetch_array($query)){
		  $brt=number_format($hasil[ConnoteWeight]);
		  $qty=number_format($hasil[ConnoteQty]);
		  $nilai=number_format($hasil[ConnoteBillAmount]-$hasil[ConnoteBillDisc]);
      	  echo "<tr>";
      	  echo "<td align='left'>$i</td>";
      	  echo "<td align='left'>$hasil[SD_ConnoteNo]</td>";
     	  echo "<td align='left'>$hasil[ConnoteDate]</td>";
      	  echo "<td align='left'>$hasil[ConnoteRecvName]</td>";
      	  echo "<td align='left'>$hasil[CityName]</td>";
      	  echo "<td align='right'>$brt</td>";
      	  echo "<td align='right'>$qty</td>";
      	  echo "<td align='right'>$nilai</td>";
    	  echo "</tr>";
	  	  $i++;
		  $totnilai=$totnilai+$hasil[ConnoteBillAmount]-$hasil[ConnoteBillDisc];
	  	}
	  $gnilai=number_format($totnilai);
	  echo "<tr>";
      echo "<td colspan='8'><hr /> </td>";
	  echo "</tr>";
      echo "<tr>";
      echo "<td></td>";
      echo "<td></td>";
      echo "<td></td>";
      echo "<td></td>";
      echo "<td></td>";
      echo "<td></td>";
      echo "<td></td>";
      echo "<td align='right'>$gnilai</td>";
      echo "</tr>";
		
	?>
	</table>
  </div>
</body>
</html>